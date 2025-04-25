<?php

namespace Modules\WriterManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\JobCardManagement\App\Models\JobCard;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\LanguageManagement\App\Models\Language;
use Modules\WriterManagement\App\Models\Writer;
use Modules\WriterManagement\App\Models\WriterLanguageMap;
use Modules\WriterManagement\App\Models\WriterPayment;

class WriterManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $writers = Writer::with('writer_language_map.language')->orderBy('created_at', 'desc')->get();
        return view('writermanagement::index')->with('writers',$writers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        return view('writermanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'writer_name' => 'required',
            'email' => 'required|email|unique:writers',
            'phone_no' => 'required|numeric',
            'address' => 'nullable',
            'code'=>'required' 
        ]);
        $writer=new Writer();
        $writer->writer_name=$request->writer_name;
        $writer->email=$request->email;
        $writer->phone_no=$request->phone_no;
        $writer->landline=$request->landline;
        $writer->address=$request->address;
        $writer->code=$request->code;
        $writer->created_by=auth()->user()->id;
        $writer->updated_by=auth()->user()->id;
        $writer->save();
        return redirect()->route('writermanagement.index')->with('message','Writer Added Successfully');

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $writer=Writer::find($id);
        return view('writermanagement::show')->with('writer',$writer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $writer=Writer::find($id);
        $language_map=WriterLanguageMap::with('language')->where('writer_id',$id)->orderBy('created_at', 'desc')->get();
        $payments= WriterPayment::where('writer_id',$id)->orderBy('created_at', 'desc')->get();
        return view('writermanagement::edit',compact('writer','language_map','payments'))->with('id',$id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'writer_name' => 'required',
            'email' => 'required|email|unique:writers,email,'.$id,
            'phone_no' => 'required|numeric',
            'address' => 'nullable',
            'code'=>'required' 
        ]);
        $writer=Writer::find($id);
        $writer->writer_name=$request->writer_name;
        $writer->email=$request->email;
        $writer->phone_no=$request->phone_no;
        $writer->landline=$request->landline;
        $writer->address=$request->address;
        $writer->code=$request->code;
        $writer->updated_by=auth()->user()->id;
        $writer->save();
        return redirect()->route('writermanagement.index')->with('message','Writer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function viewLanguageMaps($writer_id){
        $language_map=WriterLanguageMap::with('language')->where('writer_id',$writer_id)->orderBy('created_at', 'desc')->get();
        return view('writermanagement::language-maps')->with('language_map',$language_map)->with('id',$writer_id);
    }

    public  function deleteLanguageMap($writer_id,$id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $language_map=WriterLanguageMap::find($id);
        $language_map->delete();
        return redirect()->back();
    }

    public function editLanguageMap($writer_id,$id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $languages=Language::orderBy('created_at', 'desc')->get();
        $language_map=WriterLanguageMap::find($id);
        
        return view('writermanagement::edit-language')->with('language_map',$language_map)->with('id',$writer_id)->with('languages',$languages);
    }

    public function updateLanguageMap($writer_id,$id,Request $request){
       
        $request->validate([
            'language' => 'required|exists:languages,id',
            'per_unit_charges' => 'required|numeric',
            'checking_charges'=>'required|numeric',
            'bt_charges'=>'required|numeric',
            'bt_checking_charges'=>'required|numeric',
            'advertising_charges'=>'required|numeric',
            'verification_2'=> 'required|numeric',
        ]);
        $language_map=WriterLanguageMap::find($id);
        $language_map->language_id=$request->language;
        $language_map->per_unit_charges=$request->per_unit_charges;
        $language_map->checking_charges=$request->checking_charges;
        $language_map->bt_charges=$request->bt_charges;
        $language_map->bt_checking_charges=$request->bt_checking_charges;
        $language_map->verification_2= $request->verification_2;
        $language_map->advertising_charges=$request->advertising_charges;
        $language_map->save();
        Session::flash('message', 'Language Map Updated Successfully');
        return redirect()->back();
    }

    public function addLanguageMapView($writer_id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $languages=Language::orderBy('created_at', 'desc')->get();
        return view('writermanagement::add-language')->with('id',$writer_id)->with('languages',$languages);
    }

    public function addLanguageMap($writer_id,Request $request){
        $request->validate([
            'language' => 'required|exists:languages,id',
            'per_unit_charges' => 'required|numeric',
            'checking_charges'=>'required|numeric',
            'bt_charges'=>'required|numeric',
            'bt_checking_charges'=>'required|numeric',
            'advertising_charges'=>'required|numeric',
            'verification_2'=> 'required|numeric',
        ]);
        $language_map=new WriterLanguageMap();
        $language_map->writer_id=$writer_id;
        $language_map->language_id=$request->language;
        $language_map->per_unit_charges=$request->per_unit_charges;
        $language_map->checking_charges=$request->checking_charges;
        $language_map->bt_charges=$request->bt_charges;
        $language_map->bt_checking_charges=$request->bt_checking_charges;
        $language_map->verification_2= $request->verification_2;
        $language_map->advertising_charges=$request->advertising_charges;
        $language_map->save();
        Session::flash('message', 'Language Map Added Successfully');
        return redirect(route('writermanagement.viewLanguageMaps',['writer_id'=>$writer_id]));
        
    }

    public function disableEnableWriter($id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $writer=Writer::find($id);
        if($writer->status==1){
            $writer->status=0;
        }else{
            $writer->status=1;
        }
        $writer->save();
        return redirect()->route('writermanagement.index');
    }


    public function viewPayments($writer_id){
       $writer_payments= WriterPayment::where('writer_id',$writer_id)->orderBy('created_at', 'desc')->get();
       return view('writermanagement::view-payments')->with('id',$writer_id)->with('payments',$writer_payments);
    }

    public function addPaymentView($writer_id){
        if(!(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        return view('writermanagement::add-payment')->with('id',$writer_id);
    }

    public function addPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'writer_id' => 'required|string',
            'payment_method' => 'required|string',
            'metrix' => 'required|string',
            'apply_gst' => 'required|boolean',
            'apply_tds' => 'required|boolean',
            'period_from' => 'required|date',
            'total_amount' => 'required|numeric',
            'period_to' => 'required|date',
            'online_ref_no' => 'nullable|string',
            'cheque_no' => 'nullable|string',
            'performance_charge' => 'nullable|numeric',
            'deductible' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $request['created_by'] = auth()->user()->id;
        $payment = new WriterPayment($request->all());
        $payment->save();

        return redirect(route('writermanagement.viewPayments',$payment->writer_id))->with('message', 'Payment added successfully.');
    }

    public function editPaymentView($writer_id,$id){
        if(!(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $payment = WriterPayment::find($id);
        return view('writermanagement::edit-payment')->with('payment',$payment)->with('id',$writer_id);
    }

    public function editPayment(Request $request, $writer_id,$id)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string',
            'metrix' => 'required|string',
            'apply_gst' => 'required|boolean',
            'apply_tds' => 'required|boolean',
            'period_from' => 'required|date',
            'period_to' => 'required|date',
            'total_amount' => 'required|numeric',
            'online_ref_no' => 'nullable|string',
            'cheque_no' => 'nullable|string',
            'performance_charge' => 'nullable|numeric',
            'deductible' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $payment = WriterPayment::where('id',$id)->first();
        $payment->update($request->all());
        
        return redirect()->back()->with('message', 'Payment updated successfully.');;
    }

    public function showPayment($writer_id,$id)
    {
        $payment = WriterPayment::findOrFail($id);
        return view('writermanagement::show-payments', compact('payment'));
    }

    public function calculatePayment(Request $request){
        // Parse and format date ranges
        $min = Carbon::parse($request->period_from)->startOfDay()->format('Y-m-d H:i:s');
        $max = Carbon::parse($request->period_to)->endOfDay()->format('Y-m-d H:i:s');
        
        // Fetch job register IDs based on date range
        $jobRegisterIds = JobRegister::whereBetween('created_at', [$min, $max])->pluck('sr_no')->toArray();
        
        // Fetch job cards based on job register IDs
        $job_cards = JobCard::whereIn('job_no', $jobRegisterIds)->with('estimateDetail.language')->orderBy('job_no')->get();

    
        // Fetch writers with their language maps in one go
        $writers = Writer::with(['writer_language_map' => function ($query) {
            $query->with('language'); // Eager load language for filtering in-memory
        }])->where('id', $request->id)->where('code', '!=', 'INT')->get()->keyBy('id');

        // Prepare total by writers
        $totalByWriters = [];
    
        foreach ($job_cards as $job) {
            // Check and calculate for each type of unit
            $this->calculateWriterTotal($job, 't', $totalByWriters, $writers);
            $this->calculateWriterTotal($job, 'v', $totalByWriters, $writers, 'checking_charges');
            $this->calculateWriterTotal($job, 'bt', $totalByWriters, $writers, 'bt_charges');
            $this->calculateWriterTotal($job, 'btv', $totalByWriters, $writers, 'bt_checking_charges');
        }
    
        // Filter out writers with total of zero
        $totalByWriters = array_filter($totalByWriters, function ($writer) {
            return $writer['total'] != 0;
        });
        
        $total = $totalByWriters[$request->id]['total'] + ($request->apply_gst?$totalByWriters[$request->id]['total']*0.18:0) - ($request->apply_tds?$totalByWriters[$request->id]['total']*0.1:0) + ($request->performance_charge??0) - ($request->deductible ?? 0);
        return $total??0;
        // $min = Carbon::parse($request->period_from)->startOfDay()->format('Y-m-d');
        // $max = Carbon::parse($request->period_to)->endOfDay()->format('Y-m-d');

        // $jobRegisterIds = JobRegister::whereBetween('created_at',[$min,$max])->pluck('sr_no')->toArray();

        // $job_card = JobCard::whereIn('job_no',$jobRegisterIds)
        // ->where(function ($query) use ($request) {
        //     $query->where('t_writer_code', $request->id)
        //           ->orWhere('v_employee_code', $request->id)
        //           ->orWhere('bt_writer_code', $request->id)
        //           ->orWhere('v2_employee_code', $request->id);
        // })
        // ->get();

        // $total = 0;
        // foreach ($job_card as $job) {
        //     if($job->t_unit != '' && $job->t_unit != 0 && is_numeric($job->t_unit) && $job->t_writer_code == $request->id && !is_null($job->estimateDetail)){
        //         $total+=WriterLanguageMap::where('writer_id',$request->id)->where('language_id',$job->estimateDetail->language->id)->first()->per_unit_charges*$job->t_unit;
        //     }
        //     if($job->bt_unit != '' && $job->bt_unit != 0 && is_numeric($job->bt_unit) && $job->bt_writer_code == $request->id){
        //         $total+=WriterLanguageMap::where('writer_id',$request->id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_charges*$job->bt_unit;
        //     }
        //     if($job->v_unit != '' && $job->v_unit != 0 && is_numeric($job->v_unit) && $job->v_employee_code == $request->id){
        //         $total+=WriterLanguageMap::where('writer_id',$request->id)->where('language_id',$job->estimateDetail->language->id)->first()->checking_charges*$job->v_unit;
        //     }
        //     if($job->btv_unit != '' && $job->btv_unit != 0 && is_numeric($job->btv_unit) && $job->v2_employee_code == $request->id){
        //         $total+=WriterLanguageMap::where('writer_id',$request->id)->where('language_id',$job->estimateDetail->language->id)->first()->bt_checking_charges*$job->btv_unit;
        //     }
        // }
    }

    private function calculateWriterTotal($job, $type, &$totalByWriters, $writers, $chargeType = 'per_unit_charges') {
        $writerCodeField = in_array($type,['t','bt']) ? $type . '_writer_code' : $type . '_employee_code';
        $unitField = $type . '_unit';
        
        if (!empty($job->$unitField)) {
            $writer = $writers->get($job->$writerCodeField);
            
            
            if ($writer) {
                // Get the language name from the job's estimate detail
                $languageName = $job->estimateDetail?$job->estimateDetail->language->name:'';
                
                // Filter the language map by language name
                $languageMap = $writer->writer_language_map->first(function ($map) use ($languageName) {
                    return $map->language->name === $languageName;
                });
                
                if ($languageMap) {
                    if (!isset($totalByWriters[$job->$writerCodeField])) {
                        $totalByWriters[$job->$writerCodeField] = [
                            'total' => 0,
                            'name' => $writer->writer_name ?? 'Unknown',
                            'code' => $writer->code ?? 'Unknown',
                        ];
                    }
                    
                    $totalByWriters[$job->$writerCodeField]['total'] += (int)$languageMap->$chargeType * (int)$job->$unitField;
                }
            }
        }
    }

    public function paymentDelete($writer_id,$paymentId){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $payment = WriterPayment::where('id',$paymentId)->where('writer_id',$writer_id)->first();
        $payment->delete();
        return redirect(route('writermanagement.viewPayments', $writer_id));
    }
}
