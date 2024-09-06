<?php

namespace Modules\JobCardManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use DB;
use Illuminate\Http\Request;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobCardManagement\App\Models\JobCard;
use Modules\JobCardManagement\App\Sheet\JobCardExcelExport;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use App\Mail\JobCompletedBilling;
use App\Mail\JobCompleted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\LanguageManagement\App\Models\Language;
use Maatwebsite\Excel\Facades\Excel;
class JobCardManagementController extends Controller
{
    public $jobNo = null;
    public $cp = null;
    public $document = null;
    public $pm = null;
    public $contactPerson = null;
    public $from = null;
    public $to = null;
    public $status = null;

    public function index(Request $request)
    {
        if(empty($request->query()) || (array_key_exists('page', $request->query()) && count($request->query()) === 1)){
            $job_register = JobRegister::orderBy('sr_no','desc')->paginate(20);

            $statusCounts = JobRegister::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
            $job_register->complete_count = $statusCounts['1'] ?? 0;
            $job_register->cancel_count = $statusCounts['2'] ?? 0;
    
            foreach($job_register as $job_reg){
                $job_reg->isJobCard = JobCard::where('job_no',$job_reg->sr_no)->first()??false;
            }
    
            $jobNo = $this->jobNo;
            $cp = $this->cp;
            $document = $this->document;
            $pm = $this->pm;
            $contactPerson = $this->contactPerson;
            $from = $this->from;
            $to = $this->to;
            $status = $this->status;

            if ($request->ajax()) {
                return view('jobcardmanagement::_job_cards', compact('job_register','jobNo','cp','document','pm','contactPerson','from','to','status'))->render();
            }

            return view('jobcardmanagement::manage', compact('job_register','jobNo','cp','document','pm','contactPerson','from','to','status'));
        }
        $job_register = $this->jobSearch($request);
        if(count($job_register) == 0){
            return redirect()->back()->with('alert',"No job found.");
        }

        foreach($job_register as $job_reg){
            $job_reg->isJobCard = JobCard::where('job_no',$job_reg->sr_no)->first()??false;
        }

        $jobNo = $this->jobNo;
        $cp = $this->cp;
        $document = $this->document;
        $pm = $this->pm;
        $contactPerson = $this->contactPerson;
        $from = $this->from;
        $to = $this->to;
        $status = $this->status;

        if ($request->ajax()) {
            return view('jobcardmanagement::_job_cards', compact('job_register','jobNo','cp','document','pm','contactPerson','from','to','status'))->render();
        }

        return view('jobcardmanagement::manage', compact('job_register','jobNo','cp','document','pm','contactPerson','from','to','status'));
    }

    public function create($job_id,$estimate_detail_id){
        
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $job_register = JobRegister::where('id',$job_id)->first();
       
        $estimate_detail=EstimatesDetails::where('id',$estimate_detail_id)->first();
        $job_card=JobCard::where('job_no',$job_register->sr_no)->where('estimate_detail_id',$estimate_detail->id)->orderBy('created_at', 'desc')->get();
        if(count($job_card)>0){
            return view('jobcardmanagement::edit',compact('job_card','job_register','estimate_detail'));
        }
        
        return view('jobcardmanagement::create',compact('job_register','estimate_detail'));
    }

    public function viewPdf($job_id){
        $job = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
        ->where('id', $job_id)
        ->first();

        // return view('jobcardmanagement::pdf', compact('job'));
        $pdf = FacadePdf::loadView('jobcardmanagement::pdf', compact('job'));

       return  $pdf->stream();
    }

    public function store(Request $request)
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $request->validate([
            't_unit.*'=> 'nullable|string|max:255',
            't_writer.*' => 'nullable|string|max:255',
            't_pd.*' => 'nullable|string|max:255',
            't_cr.*' => 'nullable|string|max:255',
            't_cnc.*' => 'nullable|string|max:255',
            't_dv.*' => 'nullable|max:255',
            't_fqc.*' => 'nullable|string|max:255',
            't_sentdate.*' => 'nullable|string|max:255',
            'bt_writer.*' => 'nullable|string|max:255',
            'bt_unit.*'=> 'nullable|string|max:255',
            'bt_pd.*' => 'nullable|string|max:255',
            'bt_cr.*' => 'nullable|string|max:255',
            'bt_cnc.*' => 'nullable|string|max:255',
            'bt_dv.*' => 'nullable|string|max:255',
            'bt_fqc.*' => 'nullable|string|max:255',
            'bt_sentdate.*' => 'nullable|string|max:255',
        ]);

        
        $carbon=Carbon::now()->getTimestampMs();
        
        foreach ($request['t_writer'] as $index => $t_writer) {

            $jobCard = new JobCard();
            $jobCard->t_unit = $request['t_unit'][$index]?? null;
            $jobCard->t_writer_code = $t_writer?? null;
            $jobCard->t_pd = $request['t_pd'][$index]?? null;
            $jobCard->t_cr = $request['t_cr'][$index]?? null;

            $jobCard->v_unit = $request['v_unit'][$index]?? null;
            $jobCard->v_pd = $request['v_pd'][$index]?? null;
            $jobCard->v_cr = $request['v_cr'][$index]?? null;
            $jobCard->v_employee_code = $request['v_employee_code'][$index]?? null;

            $jobCard->v2_unit = $request['v2_unit'][$index]?? null;
            $jobCard->v2_pd = $request['v2_pd'][$index]?? null;
            $jobCard->v2_cr = $request['v2_cr'][$index]?? null;
            $jobCard->v2_employee_code = $request['v2_employee_code'][$index]?? null;

            $jobCard->t_cnc = $request['t_cnc'][$index]?? null;
            $jobCard->t_dv = $request['t_dv'][$index]?? null;
            $jobCard->t_fqc = $request['t_fqc'][$index]??null;
            // $jobCard->t_sentdate = $request['t_sentdate'][0]??null;

            $jobCard->bt_unit = $request['bt_unit'][$index] ?? null;
            $jobCard->bt_writer_code = $request['bt_writer'][$index] ?? null;
            $jobCard->bt_pd = $request['bt_pd'][$index] ?? null;
            $jobCard->bt_cr = $request['bt_cr'][$index] ?? null;

            $jobCard->btv_unit = $request['btv_unit'][$index]?? null;
            $jobCard->btv_employee_code = $request['btv_employee_code'][$index]?? null;
            $jobCard->btv_pd = $request['btv_pd'][$index]?? null;
            $jobCard->btv_cr = $request['btv_cr'][$index]?? null;

            $jobCard->bt_cnc = $request['bt_cnc'][$index] ?? null;
            $jobCard->bt_dv = $request['bt_dv'][$index] ?? null;
            $jobCard->bt_fqc = $request['bt_fqc'][$index] ?? null;
            // $jobCard->bt_sentdate = $request['t_sentdate'][0] ?? null;
            $jobCard->job_no = $request['job_no'][0];
            $jobCard->estimate_detail_id = $request['estimate_detail_id'][0];
            $jobCard->sync_no = $carbon;
            $jobCard->save();

        }
        $jobRegister = JobRegister::where('sr_no',$request['job_no'][0])->first();
        $jobRegister->status = 0;
        $jobRegister->save();
        $jobId = $jobRegister->id;
        $docName = EstimatesDetails::where('id',$request['estimate_detail_id'][0])->first('document_name')->document_name;
        $docName = str_replace('/', '!', $docName);
        return redirect()->route('jobcardmanagement.manage.list', ['job_id' => $jobId, 'estimate_detail_id' => $docName])->with('message', 'Job Card updated successfully.');
    }

    public function show($id)
    {
        $jobCard = JobCard::find($id);

        if (!$jobCard) {
            return abort(403, 'Job Card not found');
        }

        return view('jobcardmanagement::show')->with('jobCard', $jobCard);
    }

    public function update(Request $request, $job_register_id_and_doc_mame)
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $request->validate([
            't_writer.*' => 'nullable|string|max:255',
            't_unit.*'=> 'nullable|string|max:255',
            't_pd.*' => 'nullable|string|max:255',
            't_cr.*' => 'nullable|string|max:255',
            't_cnc.*' => 'nullable|string|max:255',
            't_dv.*' => 'nullable|max:255',
            't_fqc.*' => 'nullable|string|max:255',
            't_sentdate.*' => 'nullable|string|max:255',
            'bt_writer.*' => 'nullable|string|max:255',
            'bt_emp_code.*' => 'nullable|string|max:255',
            'bt_unit.*'=> 'nullable|string|max:255',
            'bt_pd.*' => 'nullable|string|max:255',
            'bt_cr.*' => 'nullable|string|max:255',
            'bt_cnc.*' => 'nullable|string|max:255',
            'bt_dv.*' => 'nullable|string|max:255',
            'bt_fqc.*' => 'nullable|string|max:255',
            'bt_sentdate.*' => 'nullable|string|max:255',
        ]);

        $carbon=Carbon::now()->getTimestampMs();
        
        foreach ($request['t_writer'] as $index => $t_writer) {
            JobCard::updateOrCreate([
                'id' => $request['id'][$index],
            ],[
            't_unit' => $request['t_unit'][$index]?? null,
            't_writer_code' => $t_writer?? null,
            't_pd' => $request['t_pd'][$index]?? null,
            't_cr' => $request['t_cr'][$index]?? null,

            'v_unit' => $request['v_unit'][$index]?? null,
            'v_employee_code' => $request['v_employee_code'][$index]?? null,
            'v_pd' => $request['v_pd'][$index]?? null,
            'v_cr' => $request['v_cr'][$index]?? null,

            'v2_unit' => $request['v2_unit'][$index]?? null,
            'v2_employee_code' => $request['v2_employee_code'][$index]?? null,
            'v2_pd' => $request['v2_pd'][$index]?? null,
            'v2_cr' => $request['v2_cr'][$index]?? null,

            't_cnc' => $request['t_cnc'][$index]?? null,
            't_dv' => $request['t_dv'][$index]?? null,
            't_fqc' => $request['t_fqc'][$index]?? null,
            // 't_sentdate' => $request['t_sentdate'][0]?? null,

            'bt_unit' => $request['bt_unit'][$index] ?? null,
            'bt_writer_code' => $request['bt_writer'][$index] ?? null,
            'bt_pd' => $request['bt_pd'][$index] ?? null,
            'bt_cr' => $request['bt_cr'][$index] ?? null,

            'btv_unit' => $request['btv_unit'][$index]??null,
            'btv_employee_code' => $request['btv_employee_code'][$index]??null,
            'btv_pd' => $request['btv_pd'][$index]??null,
            'btv_cr' => $request['btv_cr'][$index]??null,
            
            'bt_cnc' => $request['bt_cnc'][$index] ?? null,
            'bt_dv' => $request['bt_dv'][$index] ?? null,
            'bt_fqc' => $request['bt_fqc'][$index] ?? null,
            // 'bt_sentdate' => $request['t_sentdate'][0] ?? null,
            'job_no' => $request['job_no'][0],
            'estimate_detail_id' => $request['estimate_detail_id'][0],
            'sync_no' => $carbon,

            ]);
        }

        $param = explode("|",$job_register_id_and_doc_mame);
        $jobRegister = JobRegister::where('id',$param[0])->first();
        $jobRegister->status = 0;
        $jobRegister->save();
        return redirect()->route('jobcardmanagement.manage.list', ['job_id' => $param[0], 'estimate_detail_id' => $param[1]])->with('message', 'Job Card updated successfully.');
    }

    public function edit($id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('message', 'You are not autherized.'); 
        }
        $jobCard = JobCard::find($id);
        if(!$jobCard){
            return abort(403, 'Job Card not found');
        }
        return view('jobcardmanagement::edit')->with('jobCard', $jobCard);
    }

    public function getEstimateNo($client_id){
        if ($client_id==null&&$client_id=='') {
            $html = '<option value="">Select Estimate Number</option>';
        } else {
            
            $html = '<option value="">Select Estimate Number</option>';
            $estimates=Estimates::where('client_id',$client_id)->orderBy('created_at', 'desc')->get();
            
            foreach ($estimates as $estimate) {
                $html .= '<option value='.$estimate->id.'>'.$estimate->estimate_no.'</option>';
            }
        }
    
        return response()->json(['html' => $html]);
    }

    public function manage($job_id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('message', 'You are not autherized.'); 
        }
        $job_register = JobRegister::where('id',$job_id)->first();
        if($job_register!=null){
            $estimate_details=EstimatesDetails::where('estimate_id',$job_register->estimate_id)->where('document_name',$job_register->estimate_document_id)->orderBy('created_at', 'desc')->get();
            
            return view('jobcardmanagement::manage',compact('job_register','estimate_details'));
        }else{
            return abort(403, 'Job Register not found');
        }
        
    }

    public function manageDelete($job_card_id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return abort(403, 'Unauthorized action.');
        }
        $job_card = JobCard::find($job_card_id);
        if($job_card!=null){
            $job_card->delete();
            return response()->json(['success' => 'Job Card deleted successfully']);
        }else{
            return abort(403, 'Job Card not found');
        }
    }

    public function listEstimateDetailsLanguage($job_id,$estimate_detail_id){
        $estimate_detail_id = str_replace('!', '/', $estimate_detail_id);
        $job_register = JobRegister::where('id',$job_id)->first();
        $estimate_detail=EstimatesDetails::where('estimate_id',$job_register->estimate_id)->where('document_name',$estimate_detail_id)->orderBy('created_at', 'desc')->get();
        $list_estimate_language=true;
        foreach($estimate_detail as $estimate){
            $jobCard = JobCard::where('job_no',$job_register->sr_no)->where('estimate_detail_id',$estimate->id)->get();
            $estimate->partCopyCreateCount = count($jobCard);
            $estimate->sentDate = $jobCard[0]->t_sentdate??'';
            $estimate->partCopyCreate = $estimate->partCopyCreateCount>0?'Yes':'No';
            $estimate->language = Language::where('id', $estimate->lang)->first();
        }
        $estimate_detail = sort_languages_job_card_lang_list($estimate_detail);
        if($estimate_detail!=null){
            return view('jobcardmanagement::manage',compact('job_id','estimate_detail','list_estimate_language','job_register'));
        }
    }

    public function billForm($job_id){
        if(!(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('message', 'You are not autherized.'); 
        }
        $job=JobRegister::where('id',$job_id)->first();
        if($job->bill_date!=null){
            return view('jobcardmanagement::bill')->with('bill_data',$job);
        }
        return view('jobcardmanagement::bill')->with('job_id',$job_id)->with('job_no',$job->sr_no)->with('job',$job);
    }

    public function addBill(Request $request,$job_id){
        if(!(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('message', 'You are not autherized.'); 
        }
        $job=JobRegister::where('id',$job_id)->first();
        $job->bill_date=$request->bill_date;
        $job->bill_no=$request->bill_no;
        $job->sent_date=$request->sent_date;
        $job->bill_amount=$request->bill_amount;
        $job->paid_amount=$request->paid_amount;
        $job->po_number=$request->po_number;
        $job->payment_status=$request->payment_status;
        $job->payment_date=$request->payment_date;
        $job->save();
        return redirect(route('jobcardmanagement.index'))->with('message', 'Bill Date added successfully.');
    }

    public function updateBill(Request $request,$job_id){
        if(!(Auth::user()->hasRole('Accounts')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('message', 'You are not autherized.'); 
        }
        $job=JobRegister::where('id',$job_id)->first();
        $job->bill_date=$request->bill_date;
        $job->bill_no=$request->bill_no;
        $job->sent_date=$request->sent_date;
        $job->po_number=$request->po_number;
        $job->bill_amount=$request->bill_amount;
        $job->paid_amount=$request->paid_amount;
        $job->payment_status=$request->payment_status;
        $job->payment_date=$request->payment_date;
        $job->save();
        return redirect(route('jobcardmanagement.index'))->with('message', 'Bill Date updated successfully.');
    }

    public function changeStatus(Request $request,$id,$status){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.');
        }
        if(in_array($status,[0,1,2])){
            $job_register = JobRegister::where('id', $id)->first();
            if($status == 1){
                $estimate_detail = EstimatesDetails::where('estimate_id',$job_register->estimate_id)->where('document_name',$job_register->estimate_document_id)->orderBy('created_at', 'desc')->get();
                foreach($estimate_detail as $estimate){
                    $allPartCopy = JobCard::where('job_no',$job_register->sr_no)->where('estimate_detail_id',$estimate->id)->orderBy('created_at', 'desc')->get();
                    if(count($allPartCopy) == 0){
                        $langName = Language::where('id',$estimate->lang)->first('name')->name;
                        return back()->with('alert', 'Please enter all language part copy of '.$langName.' in Job No: '.$job_register->sr_no);
                    }
                    foreach($allPartCopy as $partCopy){
                        if($estimate->t){
                            if( is_null($partCopy->t_unit) || is_null($partCopy->t_writer_code) || is_null($partCopy->t_pd) || is_null($partCopy->t_cr) ){
                                $langName = Language::where('id',$estimate->lang)->first('name')->name;
                                return back()->with('alert', 'Please enter Translation details of '.$langName.' in Job No: '.$job_register->sr_no);
                            }
                        }else if( !is_null($partCopy->v_employee_code) && ( is_null($partCopy->v_pd) || is_null($partCopy->v_cr) ) ){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter Verification PD and CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }else if( !is_null($partCopy->v2_employee_code) && ( is_null($partCopy->v2_pd) || is_null($partCopy->v2_cr) ) ){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter 2 way verification PD and CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }else if( !is_null($partCopy->bt_writer_code) && ( is_null($partCopy->bt_pd) || is_null($partCopy->bt_cr) ) ){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter Back Translation PD and CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }else if( !is_null($partCopy->btv_employee_code) && ( is_null($partCopy->btv_pd) || is_null($partCopy->btv_cr) ) ){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter Back Translation PD and CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }else if( is_null($partCopy->t_sentdate) || is_null($partCopy->bt_sentdate) ){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter Sent Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }
                    }
                }
            }
            $job_register->status = $status;
            $job_register->cancel_reason = $request->reason??null;
            $job_register->updated_at = Carbon::now();
            $job_register->save();
            if($status==1){
                $recipient = $job_register->client->client_accountant->email;
                Mail::to($recipient)->send(new JobCompletedBilling($job_register));
                // $recipients=config('app.recipients');
                // foreach ($recipients as $recipient) {
                    // Mail::to($recipient)->send(new JobCompletedBilling($job_register));
                // }
                return redirect('/job-card-management')->with('message', 'Job completed and email has been sent.');
            }
            return redirect()->back()->with('message', 'Status changed successfully.');
        }
        return back()->with('alert', 'Can not find job status.');
    }

    public function exportJobCard(Request $request)
    {
        if($request->get('jobNo') != ''){
            $this->jobNo = $request->get('jobNo');
            $this->cp = $this->document = $this->pm = $this->contactPerson = $this->from = $this->to = $this->status = null;
            $job_register = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
            ->where('sr_no',$this->jobNo)
            ->orderBy('sr_no','desc')
            ->paginate(20);
            if( $job_register->count() == 0 ){
                return redirect()->back()->with('alert',"No job found.");
            }
            if($job_register[0]->status == 1){
                $job_register->complete_count = 1;
                $job_register->cancel_count = 0;
            }else if($job_register[0]->status == 2){
                $job_register->complete_count = 0;
                $job_register->cancel_count = 1;
            }else{
                $job_register->complete_count = 0;
                $job_register->cancel_count = 0;
            }
            $jobCard = $job_register;
            $excelFormat = collect();
            foreach($jobCard as $index => $job){
                $langIds = EstimatesDetails::where('estimate_id',$job->estimate_id)->where('document_name',$job->estimate_document_id)->pluck('lang');
                $languages = implode(", ",Language::whereIn('id',$langIds)->pluck('code')->toArray());
                $excelFormat->push([
                    'sr' => $index+1,
                    'date' => $job->date?Carbon::parse($job->created_at)->format('j M Y'):'',
                    'sr_no' => $job->sr_no,
                    'handledBy' => $job->handle_by->code??'',
                    'clientName' => $job->estimate?$job->estimate->client->name:$job->no_estimate->client->name,
                    'clientContact' => $job->estimate?$job->estimate->client_person->name:($job->no_estimate->client_person->name??''),
                    'estimateNo' => $job->estimate?$job->estimate->estimate_no:'No Estimate',
                    'languages' => $languages,
                    'oldJobNo' => $job->old_job_no??'',
                    'protocolNo' => $job->protocol_no,
                    'jobType' => $job->type??'',
                    'docName' => $job->estimate_document_id,
                    'remark' => $job->remark??'',
                    'status' => $job->status == 0 ? 'In Progress' : ($job->status == 1 ? 'Completed' : 'Canceled')
                ]);
            }
            $todayDate = Carbon::now()->format('j-M-Y');
            return Excel::download(new JobCardExcelExport($excelFormat), "job-card-export-sheet-{$todayDate}.xlsx");
        }
        $endDate = Carbon::now()->format('Y-m-d');

        $this->jobNo = null;
        $this->cp = $request->get('cp', null);
        $this->document = $request->get('document', null);
        $this->pm = $request->get('pm', null);
        $this->contactPerson = $request->get('contactPerson', null);
        $this->from = $request->get('from', null);
        $this->to = $request->get('to', null);
        $this->status =  $request->get('status', null);

        $clientIds = $this->cp?Client::where('name','like',"%{$this->cp}%")->pluck('id')->toArray():[];
        $userIds = $this->pm?User::where('name','like',"%{$this->pm}%")->orWhere('code','like',"%{$this->pm}%")->pluck('id')->toArray():[];
        $clientContactIds = $this->contactPerson?ContactPerson::where('name','like',"%{$this->contactPerson}%")->pluck('id')->toArray():[];
        $job_register_query = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
        ->when(count($clientIds)>0, function ($query) use ($clientIds) {
            $query->whereIn('client_id', $clientIds);
        })
        ->when(count($clientIds)==0 && $this->cp, function ($query){
            $query->where('protocol_no','like',"%{$this->cp}%");
        })
        ->when($this->document, function ($query){
            $query->where('description','like',"%{$this->document}%");
        })
        ->when(count($userIds)>0, function ($query) use ($userIds) {
            $query->whereIn('handled_by_id',$userIds);
        })
        ->when(count($clientContactIds)>0, function ($query) use ($clientContactIds) {
            $query->whereIn('client_contact_person_id',$clientContactIds);
        })
        ->when($this->from && $this->to, function ($query){
            $query->whereBetween('created_at', [
                Carbon::parse($this->from)->startOfDay()->format('Y-m-d H:i:s'),
                Carbon::parse($this->to)->endOfDay()->format('Y-m-d H:i:s')
            ]);
        })
        ->when($this->from, function ($query) use ($endDate){
            $query->whereBetween('created_at', [$this->from,$endDate]);
        })
        ->when(in_array($this->status,['0','1','2']), function ($query){
            $query->where('status',$this->status);
        });
        $statusCountsQuery = clone $job_register_query;
        $job_register = $job_register_query->orderBy('sr_no', 'desc')->get();
        if( $job_register->count() == 0 ){
            return [];  
        }
        $statusCounts = $statusCountsQuery->select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
        
        $job_register->complete_count = $statusCounts['1'] ?? 0;
        $job_register->cancel_count = $statusCounts['2'] ?? 0;
        $jobCard = $job_register;
        if($jobCard->count() == 0){
            return redirect()->back()->with('alert',"No job found.");
        }
        $excelFormat = collect();
        foreach($jobCard as $index => $job){
            $langIds = EstimatesDetails::where('estimate_id',$job->estimate_id)->where('document_name',$job->estimate_document_id)->pluck('lang');
            $languages = implode(", ",Language::whereIn('id',$langIds)->pluck('code')->toArray());
            $excelFormat->push([
                'sr' => $index+1,
                'date' => $job->date?Carbon::parse($job->created_at)->format('j M Y'):'',
                'sr_no' => $job->sr_no,
                'handledBy' => $job->handle_by->code??'',
                'clientName' => $job->estimate?$job->estimate->client->name:$job->no_estimate->client->name,
                'clientContact' => $job->estimate?$job->estimate->client_person->name:($job->no_estimate->client_person->name??''),
                'estimateNo' => $job->estimate?$job->estimate->estimate_no:'No Estimate',
                'languages' => $languages,
                'oldJobNo' => $job->old_job_no??'',
                'protocolNo' => $job->protocol_no,
                'jobType' => $job->type??'',
                'docName' => $job->estimate_document_id,
                'remark' => $job->remark??'',
                'status' => $job->status == 0 ? 'In Progress' : ($job->status == 1 ? 'Completed' : 'Canceled')
            ]);
        }
        $todayDate = Carbon::now()->format('j-M-Y');
        return Excel::download(new JobCardExcelExport($excelFormat), "job-card-export-sheet-{$todayDate}.xlsx");
        // $pdf = FacadePdf::loadView('jobcardmanagement::pdf.export-job-card', ['jobCard'=> $jobCard])->setPaper('a4', 'landscape');
        // return $pdf->stream();
    }

    public function jobSearch($request){
        if($request->get('jobNo') != ''){
            $this->jobNo = $request->get('jobNo');
            $this->cp = $this->document = $this->pm = $this->contactPerson = $this->from = $this->to = $this->status = null;
            $job_register = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
            ->where('sr_no',$this->jobNo)
            ->orderBy('sr_no','desc')
            ->paginate(20);
            if( $job_register->count() == 0 ){
                return [];  
            }
            if($job_register[0]->status == 1){
                $job_register->complete_count = 1;
                $job_register->cancel_count = 0;
            }else if($job_register[0]->status == 2){
                $job_register->complete_count = 0;
                $job_register->cancel_count = 1;
            }else{
                $job_register->complete_count = 0;
                $job_register->cancel_count = 0;
            }
            return $job_register;
        }
        $endDate = Carbon::now()->format('Y-m-d');

        $this->jobNo = null;
        $this->cp = $request->get('cp', null);
        $this->document = $request->get('document', null);
        $this->pm = $request->get('pm', null);
        $this->contactPerson = $request->get('contactPerson', null);
        $this->from = $request->get('from', null);
        $this->to = $request->get('to', null);
        $this->status =  $request->get('status', null);

        $clientIds = $this->cp?Client::where('name','like',"%{$this->cp}%")->pluck('id')->toArray():[];
        $userIds = $this->pm?User::where('name','like',"%{$this->pm}%")->orWhere('code','like',"%{$this->pm}%")->pluck('id')->toArray():[];
        $clientContactIds = $this->contactPerson?ContactPerson::where('name','like',"%{$this->contactPerson}%")->pluck('id')->toArray():[];
        $job_register_query = JobRegister::with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])
        ->when(count($clientIds)>0, function ($query) use ($clientIds) {
            $query->whereIn('client_id', $clientIds);
        })
        ->when(count($clientIds)==0 && $this->cp, function ($query){
            $query->where('protocol_no','like',"%{$this->cp}%");
        })
        ->when($this->document, function ($query){
            $query->where('description','like',"%{$this->document}%");
        })
        ->when(count($userIds)>0, function ($query) use ($userIds) {
            $query->whereIn('handled_by_id',$userIds);
        })
        ->when(count($clientContactIds)>0, function ($query) use ($clientContactIds) {
            $query->whereIn('client_contact_person_id',$clientContactIds);
        })
        ->when($this->from && $this->to, function ($query){
            $query->whereBetween('created_at', [
                Carbon::parse($this->from)->startOfDay()->format('Y-m-d H:i:s'),
                Carbon::parse($this->to)->endOfDay()->format('Y-m-d H:i:s')
            ]);
        })
        ->when($this->from, function ($query) use ($endDate){
            $query->whereBetween('created_at', [$this->from,$endDate]);
        })
        ->when(in_array($this->status,['0','1','2']), function ($query){
            $query->where('status',$this->status);
        });
        $statusCountsQuery = clone $job_register_query;
        $job_register = $job_register_query->orderBy('sr_no', 'desc')->paginate(20);
        if( $job_register->count() == 0 ){
            return [];  
        }
        $statusCounts = $statusCountsQuery->select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status');
        
        $job_register->complete_count = $statusCounts['1'] ?? 0;
        $job_register->cancel_count = $statusCounts['2'] ?? 0;
        return $job_register;
    }

    public function changeRemark(Request $request,$id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.');
        }
        $job_register = JobRegister::where('id', $id)->first();
        $job_register->remark = $request->remark??null;
        $job_register->save();
        return redirect()->back()->with('message', 'Remark updated successfully.');
    }

    public function getRemark($id){
        $job_register = JobRegister::where('id', $id)->first();
        return $job_register?$job_register->remark:'';
    }

    public function wUText(Request $request,$id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.');
        }
        $job_register = JobRegister::where('id', $id)->first();
        $job_register->wu_text = $request->wu??null;
        $job_register->save();
        return redirect()->back()->with('message', 'Words/Units updated successfully.');
    }

    public function sentDate(Request $request, $jobRegisterId, $jobNo, $estimateDetailId, $estimateDocumentId){ 
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager')||Auth::user()->hasRole('Accounts'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        
        $jobCards = JobCard::where('job_no',$jobNo)->where('estimate_detail_id',$estimateDetailId)->get();

        if(count($jobCards) == 0){
            return redirect()->back()->with('alert', 'No job card found.'); 
        }
        foreach ($jobCards as $index => $jobCard) {
            $jobCard->t_sentdate = $request->date??null;
            $jobCard->bt_sentdate = $request->date??null;
            $jobCard->save();
        }
        // route('jobcardmanagement.manage.list', ['job_id' => $row->id, 'estimate_detail_id' => $row->estimate_document_id])
        return redirect()->route('jobcardmanagement.manage.list', ['job_id' => $jobRegisterId, 'estimate_detail_id' => $estimateDocumentId])->with('message', 'Sent date updated successfully.');
    }
}
