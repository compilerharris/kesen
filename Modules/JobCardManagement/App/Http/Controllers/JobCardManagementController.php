<?php

namespace Modules\JobCardManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
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

    public function index(){ 
      
        if(!request()->get("reset")){
            if(request()->get("min")&&request()->get("max")==null) {
                $job_register=JobRegister::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])->get();
            }elseif(request()->get("min")!=''&&request()->get("max")!='') {
                $job_register=JobRegister::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->where('created_at', '<=',Carbon::parse(request()->get("max"))->endOfDay())->with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])->get();    
            }elseif(request()->get("min")==null&&request()->get("max")){
                $job_register=JobRegister::where('created_at', '<=',Carbon::parse(request()->get("max"))->endOfDay())->with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])->get();
            }else{
                $min=Carbon::now()->startOfMonth();
                $max=Carbon::now()->endOfMonth();
                $job_register=JobRegister::where('created_at', '>=', $min)->where('created_at', '<=', $max)->with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])->orderBy('created_at', 'desc')->get();
            }
        }else{
            return redirect('/job-card-management');
        }
        
        $job_register->complete_count=$job_register->where('status',1)->count();
        $job_register->cancel_count=$job_register->where('status',2)->count();
        return view('jobcardmanagement::manage',compact('job_register'));
        
    }

    public function create($job_id,$estimate_detail_id){
        
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $job_register = JobRegister::where('id',$job_id)->first();
       
        $estimate_detail=EstimatesDetails::where('id',$estimate_detail_id)->first();
        $job_card=JobCard::where('job_no',$job_register->sr_no)->where('estimate_detail_id',$estimate_detail->id)->get();
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
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $request->validate([
            't_unit.*'=> 'required|string|max:255',
            't_writer.*' => 'required|string|max:255',
            't_pd.*' => 'required|string|max:255',
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
            $jobCard->t_unit = $request['t_unit'][$index];
            $jobCard->t_writer_code = $t_writer;
            $jobCard->t_pd = $request['t_pd'][$index];
            $jobCard->t_cr = $request['t_cr'][$index];

            $jobCard->v_unit = $request['v_unit'][$index]?? null;
            $jobCard->v_pd = $request['v_pd'][$index]?? null;
            $jobCard->v_cr = $request['v_cr'][$index]?? null;
            $jobCard->v_employee_code = $request['v_employee_code'][$index]?? null;

            $jobCard->v2_unit = $request['v2_unit'][$index]?? null;
            $jobCard->v2_pd = $request['v2_pd'][$index]?? null;
            $jobCard->v2_cr = $request['v2_cr'][$index]?? null;
            $jobCard->v2_employee_code = $request['v2_employee_code'][$index]?? null;

            $jobCard->btv_unit = $request['btv_unit'][$index]?? null;
            $jobCard->btv_pd = $request['btv_pd'][$index]?? null;
            $jobCard->btv_cr = $request['btv_cr'][$index]?? null;
            $jobCard->btv_employee_code = $request['btv_employee_code'][$index]?? null;
            $jobCard->t_cnc = $request['t_cnc'][$index]?? null;
            $jobCard->t_dv = $request['t_dv'][$index]?? null;
            $jobCard->t_fqc = $request['t_fqc'][$index]??null;
            $jobCard->t_sentdate = $request['t_sentdate'][$index]??null;
            $jobCard->bt_writer_code = $request['bt_writer'][$index] ?? null;
            $jobCard->bt_unit = $request['bt_unit'][$index] ?? null;
            $jobCard->bt_pd = $request['bt_pd'][$index] ?? null;
            $jobCard->bt_cr = $request['bt_cr'][$index] ?? null;
            $jobCard->bt_cnc = $request['bt_cnc'][$index] ?? null;
            $jobCard->bt_dv = $request['bt_dv'][$index] ?? null;
            $jobCard->bt_fqc = $request['bt_fqc'][$index] ?? null;
            $jobCard->bt_sentdate = $request['bt_sentdate'][$index] ?? null;
            $jobCard->job_no = $request['job_no'][0];
            $jobCard->estimate_detail_id = $request['estimate_detail_id'][0];
            $jobCard->sync_no = $carbon;
            $jobCard->save();

        }
        $jobId = JobRegister::where('sr_no',$request['job_no'][0])->first('id')->id;
        $docName = EstimatesDetails::where('id',$request['estimate_detail_id'][0])->first('document_name')->document_name;
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
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager'))){
            return redirect()->back()->with('message', 'You are not autherized.'); 
        }
        $request->validate([
            't_writer.*' => 'required|string|max:255',
            't_unit.*'=> 'required|string|max:255',
            't_pd.*' => 'required|string|max:255',
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
            't_writer_code' => $t_writer,
            't_pd' => $request['t_pd'][$index],
            't_cr' => $request['t_cr'][$index],
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
            't_sentdate' => $request['t_sentdate'][$index]?? null,
            't_unit' => $request['t_unit'][$index]?? null,
            'bt_unit' => $request['bt_unit'][$index] ?? null,
            'bt_writer_code' => $request['bt_writer'][$index] ?? null,
            'bt_pd' => $request['bt_pd'][$index] ?? null,
            'bt_cr' => $request['bt_cr'][$index] ?? null,
            'bt_cnc' => $request['bt_cnc'][$index] ?? null,
            'bt_dv' => $request['bt_dv'][$index] ?? null,
            'bt_fqc' => $request['bt_fqc'][$index] ?? null,
            'bt_sentdate' => $request['bt_sentdate'][$index] ?? null,
            'job_no' => $request['job_no'][0],
            'btv_unit' => $request['btv_unit'][$index]??null,
            'btv_employee_code' => $request['btv_employee_code'][$index]??null,
            'btv_pd' => $request['btv_pd'][$index]??null,
            'btv_cr' => $request['v2_cr'][$index]??null,
            'estimate_detail_id' => $request['estimate_detail_id'][0],
            'sync_no' => $carbon,

            ]);
        }


        $param = explode("|",$job_register_id_and_doc_mame);
        return redirect()->route('jobcardmanagement.manage.list', ['job_id' => $param[0], 'estimate_detail_id' => $param[1]])->with('message', 'Job Card updated successfully.');
    }

    public function edit($id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager'))){
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
            $estimates=Estimates::where('client_id',$client_id)->get();
            
            foreach ($estimates as $estimate) {
                $html .= '<option value='.$estimate->id.'>'.$estimate->estimate_no.'</option>';
            }
        }
    
        return response()->json(['html' => $html]);
    }

    public function manage($job_id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager'))){
            return redirect()->back()->with('message', 'You are not autherized.'); 
        }
        $job_register = JobRegister::where('id',$job_id)->first();
        if($job_register!=null){
            $estimate_details=EstimatesDetails::where('estimate_id',$job_register->estimate_id)->where('document_name',$job_register->estimate_document_id)->get();
            
            return view('jobcardmanagement::manage',compact('job_register','estimate_details'));
        }else{
            return abort(403, 'Job Register not found');
        }
        
    }

    public function manageDelete($job_card_id){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager'))){
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
        $job_register = JobRegister::where('id',$job_id)->first();
        $estimate_detail=EstimatesDetails::where('estimate_id',$job_register->estimate_id)->where('document_name',$estimate_detail_id)->get();
        $list_estimate_language=true;
        foreach($estimate_detail as $estimate){
            $estimate->partCopyCreate = count(JobCard::where('job_no',$job_register->sr_no)->where('estimate_detail_id',$estimate->id)->get())>0?'Yes':'No';
        }
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

    public function changeStatus($id,$status){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO')||Auth::user()->hasRole('Project Manager'))){
            return redirect()->back()->with('alert', 'You are not autherized.');
        }
        if(in_array($status,[0,1,2])){
            $job_register = JobRegister::where('id', $id)->first();
            if($status == 1){
                $estimate_detail = EstimatesDetails::where('estimate_id',$job_register->estimate_id)->where('document_name',$job_register->estimate_document_id)->get();
                foreach($estimate_detail as $estimate){
                    $allPartCopy = JobCard::where('job_no',$job_register->sr_no)->where('estimate_detail_id',$estimate->id)->get();
                    if(count($allPartCopy) == 0){
                        $langName = Language::where('id',$estimate->lang)->first('name')->name;
                        return back()->with('alert', 'Please enter all language part copy of '.$langName.' in Job No: '.$job_register->sr_no);
                    }
                    foreach($allPartCopy as $partCopy){
                        if(!$partCopy->t_cr){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter all CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }elseif($partCopy->v_pd && !$partCopy->v_cr){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter all CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }elseif($partCopy->v2_pd && !$partCopy->v2_cr){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter all CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }elseif($partCopy->bt_pd && !$partCopy->bt_cr){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter all CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }elseif($partCopy->btv_pd && !$partCopy->btv_cr){
                            $langName = Language::where('id',$estimate->lang)->first('name')->name;
                            return back()->with('alert', 'Please enter all CR Date of '.$langName.' in Job No: '.$job_register->sr_no);
                        }
                    }
                }
            }
            $job_register->status = $status;
            $job_register->updated_at = Carbon::now();
            $job_register->save();
            if($status==1){
                $recipients=config('app.recipients');
                foreach ($recipients as $recipient) {
                    Mail::to($recipient)->send(new JobCompletedBilling($job_register));
                }
                return redirect('/job-card-management')->with('message', 'Job completed and email has been sent.');    
            }
            return redirect('/job-card-management')->with('message', 'Status changed successfully.');
        }
        return back()->with('alert', 'Can not find job status.');
    }

    public function exportJobCard()
    {
        if(!request()->get("reset")){
            if(request()->get("min")&&request()->get("max")==null) {
                $jobCard = JobRegister::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->get();    
            }elseif(request()->get("min")!=''&&request()->get("max")!='') {
                $jobCard = JobRegister::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->get();    
            }elseif(request()->get("min")==null&&request()->get("max")){
                $jobCard = JobRegister::where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->get();    
            }else{
                $min=Carbon::now()->startOfMonth();
                $max=Carbon::now()->endOfMonth();
                $jobCard = JobRegister::where('created_at', '>=', $min)->where('created_at', '<=', $max)->get();    
            }
        }else{
            $min=Carbon::now()->startOfMonth();
            $max=Carbon::now()->endOfMonth();
            $jobCard = JobRegister::where('created_at', '>=', $min)->where('created_at', '<=', $max)->get();    
        }
        $jobCard->complete_count=$jobCard->where('status',1)->count();
        $jobCard->cancel_count=$jobCard->where('status',2)->count();
        foreach($jobCard as $job){
            $langIds = EstimatesDetails::where('estimate_id',$job->estimate_id)->where('document_name',$job->estimate_document_id)->pluck('lang');
            $job->languages = implode(", ",Language::whereIn('id',$langIds)->pluck('name')->toArray());
        }
        // return Excel::download(new JobCardExcelExport($jobCard), 'job-card.xlsx');
        $pdf = FacadePdf::loadView('jobcardmanagement::pdf.export-job-card', ['jobCard'=> $jobCard])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
