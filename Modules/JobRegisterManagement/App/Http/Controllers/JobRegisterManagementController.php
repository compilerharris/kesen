<?php

namespace Modules\JobRegisterManagement\App\Http\Controllers;

use App\Mail\JobConfirmationMail;
use App\Models\User;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\EstimateManagement\App\Models\NoEstimates;
use Modules\JobRegisterManagement\App\Sheet\KesenExport;
use App\Http\Controllers\Controller;
use App\Mail\JobCompleted;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ClientManagement\App\Models\Client;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\LanguageManagement\App\Models\Language;
use \Carbon\Carbon;

class JobRegisterManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        if($request->get('search') != ''){
            return $this->jobSearch($request);
        }
        if(!$request->get('min')&& !$request->get('max')){
            $job_registers = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            $min = null;
            $max = null;
        }else{
            $noOfDays = env('NO_OF_DAYS', 30);
            $startDate = Carbon::now()->subDays($noOfDays)->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');

            // Fetch min and max dates from the request
            $min = $request->get('min', $startDate);
            $max = $request->get('max', $endDate);

            // Build the query with dynamic filters
            $job_registers = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
                ->when($min && $max, function ($query) use ($min, $max) {
                    $query->whereBetween('created_at', [$min,$max]);
                })
                ->when($min, function ($query) use ($min) {
                    $query->where('created_at', '>=',$min);
                })
                ->when($max, function ($query) use ($max) {
                    $query->where('created_at', '<=',$max);
                })
                ->orderBy('created_at', 'desc')
                // ->get();
                ->paginate(10); // 10 records per page
        }

        // Count complete and canceled jobs
        $job_registers->complete_count = $job_registers->where('status', 1)->count();
        $job_registers->cancel_count = $job_registers->where('status', 2)->count();

        // Check if the request is AJAX and return the partial view if true
        if ($request->ajax()) {
            return view('jobregistermanagement::_job_registers', compact('job_registers', 'min', 'max'))->render();
        }

        return view('jobregistermanagement::index', compact('job_registers', 'min', 'max'));


        // $noOfDays = env('NO_OF_DAYS', 30);
        // $startDate = Carbon::now()->subDays($noOfDays)->format('Y-m-d');
        // $endDate = Carbon::now()->format('Y-m-d');
        // $job_registers=JobRegister::whereBetween('created_at',[$startDate,$endDate])->orderBy('created_at', 'desc')->get();
        // return view('jobregistermanagement::index')->with('job_registers',$job_registers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        return view('jobregistermanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estimate_id' => 'required|string',
            'handled_by_id' => 'required|string',
            'other_details' => 'nullable|array',
            'estimate_document_id' => 'nullable',
            'category' => 'required|integer',
            'type' => 'nullable|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'protocol_no' => 'nullable|string',
            'version_date' => 'nullable|string',
            'version_no' => 'nullable|string',
            'status' => 'nullable|integer',
            'cancel_reason' => 'nullable|string',
            'bill_no' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'informed_to' => 'nullable|string|max:255',
            'invoice_date' => 'nullable|date',
            'sent_date' => 'nullable|date',
            'operator' => 'nullable|string',
            #'site_specific' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->estimate_id == 'no_estimate'){
            $estimate = new NoEstimates();
            $estimate->client_id = $request->client_id;
            $estimate->client_contact_person_id = $request->client_contact_person_id;
            $estimate->created_by = Auth()->user()->id;
            $estimate->updated_by = Auth()->user()->id;
            $estimate->save();
            if ($request->document_name != null) {
                foreach($request->lang as $language) {
                    if(isset($language)&&$language!=null&&$language!='')
                       {
                        EstimatesDetails::updateOrCreate([
                            'estimate_id' => $estimate->id,
                            'document_name' => $request->document_name,
                            'lang' => $language,
                        ], [
                            'estimate_id' => $estimate->id,
                            'document_name' => $request->document_name,
                            'estimate_type' => 'no_estimate',
                            'type' => "NA",
                            'unit' => "0",
                            'rate' => 0,
                            'v1' => isset($request['v1']) && $request['v1'] === 'on' ? true : false,
                            'v2' => isset($request['v2']) && $request['v2'] === 'on' ? true : false,
                            'bt' => isset($request['bt']) && $request['bt'] === 'on' ? true : false,
                            'btv' => isset($request['btv']) && $request['btv'] === 'on' ? true : false,
                            'verification' => null,
                            'verification_2' => null,
                            'back_translation' => null,
                            'layout_charges' => null,
                            'layout_charges_2' => null,
                            'lang' => $language,
                            'two_way_qc_t' => null,
                            'two_way_qc_bt' => null,
                        ]);
                    }
                }
                $job_register=new JobRegister();
                $job_register->client_id = $request->client_id;
                $job_register->client_contact_person_id = $request->client_contact_person_id;
                $job_register->estimate_id = $estimate->id;
                $job_register->handled_by_id = $request->handled_by_id;
                $job_register->created_by_id = auth()->user()->id;
                $job_register->other_details = $request->other_details!=null?implode(',',$request->other_details):null;
                $job_register->category = $request->category;
                $job_register->estimate_document_id = $request->document_name;
                $job_register->type = $request->type;
                $job_register->old_job_no=$request->old_job_no??'';
                $job_register->client_accountant_person_id = $request->client_contact_person_id;
                $job_register->date = $request->date;
                $job_register->description = $request->document_name;
                $job_register->protocol_no = $request->protocol_no;
                $job_register->version_date = $request->version_date;
                $job_register->version_no = $request->version_no;
                $job_register->status = 0;
                $job_register->cancel_reason = $request->cancel_reason;
                $job_register->bill_no = $request->bill_no;
                $job_register->bill_date = $request->bill_date;
                $job_register->informed_to = $request->client_contact_person_id;
                $job_register->invoice_date = $request->invoice_date;
                $job_register->sent_date = $request->sent_date;
                $job_register->operator = $request->operator;
                $job_register->save();
                return redirect()->route('jobregistermanagement.index')->with('message', 'Job register created successfully.');
            }else{
                return redirect()->back()->with('alert', 'Document Not Found.');
            }
        }
        $job_register=new JobRegister();
        $job_register->client_id = Estimates::where('id',$request->estimate_id)->first()->client_id;
        $job_register->client_contact_person_id =  Estimates::where('id',$request->estimate_id)->first()->client_contact_person_id;
        $job_register->estimate_id = $request->estimate_id;
        $job_register->handled_by_id = $request->handled_by_id;
        $job_register->created_by_id = auth()->user()->id;
        $job_register->other_details = $request->other_details!=null?implode(',',$request->other_details):null;
        $job_register->category = $request->category;
        $job_register->estimate_document_id = $request->estimate_document_id;
        $job_register->type = $request->type;
        $job_register->old_job_no=$request->old_job_no??'';
        $job_register->client_accountant_person_id = Client::where('id',Estimates::where('id',$request->estimate_id)->first()->client_id)->first()->client_accountant_person_id;
        $job_register->date = $request->date;
        $job_register->description = $request->estimate_document_id;
        $job_register->protocol_no = $request->protocol_no;
        $job_register->version_date = $request->version_date;
        $job_register->version_no = $request->version_no;
        $job_register->status = 0;
        $job_register->cancel_reason = $request->cancel_reason;
        $job_register->bill_no = $request->bill_no;
        $job_register->bill_date = $request->bill_date;
        $job_register->informed_to = $request->client_contact_person_id;
        $job_register->invoice_date = $request->invoice_date;
        $job_register->sent_date = $request->sent_date;
        $job_register->operator = $request->operator;
        #$job_register->site_specific = $request->site_specific;
        $job_register->save();
        
        return redirect()->route('jobregistermanagement.index')->with('message', 'Job register created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
        return view('jobregistermanagement::show', compact('jobRegister'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $jobRegister = JobRegister::findOrFail($id);
        $jobRegister->languages = $jobRegister->estimate_details->pluck('lang')->toArray();
        $jobRegister->languagesNames = Language::whereIn('id', $jobRegister->languages)->get('name')->pluck('name')->toArray();
        $jobRegister->clientName = Client::where('id',$jobRegister->client_id)->first('name')->name;
       
        return view('jobregistermanagement::edit', compact('jobRegister'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'handled_by_id' => 'required|string',
            'other_details' => 'nullable|array',
            'category' => 'required|integer',
            'type' => 'nullable|string',
            'date' => 'required|date',
            'protocol_no' => 'nullable|string',
            'version_date' => 'nullable|string',
            'version_no' => 'nullable|string',
            'status' => 'nullable|integer',
            'cancel_reason' => 'nullable|string',
            'bill_no' => 'nullable|string|max:255',
            'bill_date' => 'nullable|date',
            'invoice_date' => 'nullable|date',
            'sent_date' => 'nullable|date',
            'operator' => 'nullable|string',
            #'site_specific' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $jobRegister = JobRegister::where('id', $id)->first();

        if(isset($request['lang']) && count($request['lang'])>0){
            $languages = $request['lang'];
            $estimate = NoEstimates::where('id',$jobRegister->estimate_id)->first();
            $estimate->client_id = $request->client_id;
            $estimate->client_contact_person_id = $request->client_contact_person_id;
            $estimate->updated_by = Auth()->user()->id;
            $estimate->save();

            $previous_lang=EstimatesDetails::where('document_name', $request->document_name)->where('estimate_id', $estimate->id)->get('lang')->pluck('lang')->toArray();
            $deleted_lang=array_diff($previous_lang,$languages);
            
            if(count($deleted_lang)>0){
                EstimatesDetails::where('document_name', $request->document_name)->where('estimate_id', $estimate->id)->whereIn('lang', $deleted_lang)->delete();
            }
            foreach($languages as $language) {
                if(isset($language)&&$language!=null&&$language!='')
                   {
                    EstimatesDetails::updateOrCreate([
                        'estimate_id' => $estimate->id,
                        'document_name' => $request->document_name,
                        'lang' => $language,
                    ], [
                        'estimate_id' => $estimate->id,
                        'document_name' => $request->document_name,
                        'estimate_type' => 'no_estimate',
                        'type' => "NA",
                        'unit' => "0",
                        'rate' => 0,
                        'v1' => isset($request['v1']) && $request['v1'] === 'on' ? true : false,
                        'v2' => isset($request['v2']) && $request['v2'] === 'on' ? true : false,
                        'bt' => isset($request['bt']) && $request['bt'] === 'on' ? true : false,
                        'btv' => isset($request['btv']) && $request['btv'] === 'on' ? true : false,
                        'verification' => null,
                        'verification_2' => null,
                        'back_translation' => null,
                        'layout_charges' => null,
                        'layout_charges_2' => null,
                        'lang' => $language,
                        'two_way_qc_t' => null,
                        'two_way_qc_bt' => null,
                    ]);
                }
            }
        }
        $jobRegister->handled_by_id = $request->handled_by_id;
        $jobRegister->other_details = $request->other_details!=null?implode(',',$request->other_details):null;
        $jobRegister->type = $request->type;
        $jobRegister->category = $request->category;
        $jobRegister->date = $request->date;
        $jobRegister->old_job_no=$request->old_job_no??'';
        $jobRegister->description = $request->estimate_document_id;
        $jobRegister->protocol_no = $request->protocol_no;
        $jobRegister->version_date = $request->version_date;
        $jobRegister->version_no = $request->version_no;
        $jobRegister->cancel_reason = $request->cancel_reason;
        $jobRegister->bill_no = $request->bill_no;
        $jobRegister->bill_date = $request->bill_date;
        $jobRegister->invoice_date = $request->invoice_date;
        $jobRegister->sent_date = $request->sent_date;
        $jobRegister->operator = $request->operator;
        $jobRegister->status = 0;
           # 'site_specific' => $request->site_specific,
        $jobRegister->save();
        return redirect()->route('jobregistermanagement.index')->with('message', 'Job register updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function viewPdf($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
        $pdf = Pdf::loadView('jobregistermanagement::pdf', ['jobRegister' => $jobRegister]);
        return $pdf->stream();
    }

    public function generateExcel($id)
    {
        $jobRegister = JobRegister::findOrFail($id);
        $jobRegister->is_excel_downloaded = true;
        $jobRegister->save();
        return Excel::download(new KesenExport($jobRegister), $jobRegister->sr_no.'.xlsx');
        
    }

    public function sendComplete($id){
        $jobRegister = JobRegister::findOrFail($id);
        
        // to get all languages of current document
        $language_ids = EstimatesDetails::where('estimate_id', $jobRegister->estimate_id)->where('document_name',$jobRegister->estimate_document_id)->pluck('lang')->toArray();
        $jobRegister->languages = Language::whereIn('id', $language_ids)->pluck('name')->toArray();
        
        try{
            Mail::to($jobRegister->estimate?$jobRegister->estimate->client_person->email:$jobRegister->no_estimate->client_person->email)->send(new JobConfirmationMail($jobRegister));
        }catch (\Exception $e) {
            // Handle email sending error
            return back()->with('alert', 'Failed to send confirmation email: ' . $e->getMessage());
        }
        // $pdf = Pdf::loadView('jobregistermanagement::job-register-complete-pdf', ['jobRegister' => $jobRegister]);   
        // #$pdf = SnappyPdf::loadView('jobregistermanagement::job-register-complete-pdf', compact('jobRegister'));

        // if (!$pdf->output()) {
        //   // Handle PDF generation error
        //   return back()->withErrors('Failed to generate PDF');
        // }
      
        
        // Mail::send([], [], function ($message) use ($pdf, $jobRegister) {
        //     $message->to($jobRegister->estimate->client_person->email)
        //             ->subject('Job Confirmation Letter')
        //             ->attachData($pdf->output(), 'confirmation_letter.pdf', [
        //                 'mime' => 'application/pdf',
        //             ]);
        // });
      
        return redirect('/job-register-management')->with('message', 'Confirmation email sent successfully!');
    }
    public function sendFeedBackForm($job_id){
        $job_register = JobRegister::where('id', $job_id)->first();
        $job_register->imageUrl = public_path('img/logo.png');
        Mail::to($job_register->estimate?$job_register->estimate->client_person->email:$job_register->no_estimate->client_person->email)->send(new JobCompleted($job_register));
        return redirect('/job-register-management')->with('message', 'email letter has been sent successfully!');
    }

    public function jobSearch(Request $request){ 
        if($request->get('search') == ''){
            return redirect()->back()->with('alert','Please enter job no.');
        }

        $search = $request->get('search');
        $client = Client::where('name','like',"%{$search}%")->get();
        $clientContact = ContactPerson::where('name','like',"%{$search}%")->get();
        $user = User::where('name','like',"%{$search}%")->orWhere('code','like',"%{$search}%")->get();
        $job_registers = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
        ->where('sr_no',$search)
        ->orWhere('protocol_no','like',"%{$search}%")
        ->orWhereIn('client_id',count($client)>0?$client->pluck('id')->toArray():[])
        ->orWhereIn('client_contact_person_id',count($clientContact)>0?$clientContact->pluck('id')->toArray():[])
        ->orWhereIn('handled_by_id',count($user)>0?$user->pluck('id')->toArray():[])
        ->orWhere('description','like',"%{$search}%")
        ->orWhere('status','like',"%{$search}%")
        ->paginate(10);

        if($job_registers->count() == 0){
            return redirect()->back()->with('alert',"No job found with {$search}");
        }

        $job_registers->complete_count = $job_registers->where('status', 1)->count();
        $job_registers->cancel_count = $job_registers->where('status', 2)->count();

        $min = null;
        $max = null;

        return view('jobregistermanagement::index', compact('job_registers', 'min', 'max','search'));
    }
}
