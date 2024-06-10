<?php

namespace Modules\JobCardManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobCardManagement\App\Models\JobCard;
use Modules\JobRegisterManagement\App\Models\JobRegister;

class JobCardManagementController extends Controller
{

    public function index(){ 
      
        if(!request()->get("reset")){
            if(request()->get("min")&&request()->get("max")==null) {
                $job_register=JobRegister::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])->get();
            }
            elseif(request()->get("min")!=''&&request()->get("max")!='') {
                
                $job_register=JobRegister::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->where('created_at', '<=',Carbon::parse(request()->get("max"))->endOfDay())->with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])->get();
                
            }
            elseif(request()->get("min")==null&&request()->get("max")){
                $job_register=JobRegister::where('created_at', '<=',Carbon::parse(request()->get("max"))->endOfDay())->with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])->get();
            
        }else{
            $min=Carbon::now()->startOfMonth();
            $max=Carbon::now()->endOfMonth();
            $job_register=JobRegister::where('created_at', '>=', $min)->where('created_at', '<=', $max)->with(['estimateDetail', 'jobCard', 'client', 'handle_by', 'client_person'])->get();
        }
    }else{
       return redirect('/job-card-management');
    }
        
        return view('jobcardmanagement::manage',compact('job_register'));
        
    }

    public function create($job_id,$estimate_detail_id){
        
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
        $pdf = FacadePdf::loadView('jobcardmanagement::pdf', compact('job'));

       return  $pdf->stream();
    }

    public function store(Request $request)
    {
        $request->validate([
            't_writer.*' => 'required|string|max:255',
            't_emp_code.*' => 'required|string|max:255',
            't_two_way_emp_code.*' => 'required|string|max:255',
            't_unit.*'=> 'required|string|max:255',
            't_pd.*' => 'required|string|max:255',
            't_cr.*' => 'required|string|max:255',
            't_cnc.*' => 'required|string|max:255',
            't_dv.*' => 'required|string|max:255',
            't_fqc.*' => 'required|string|max:255',
            't_sentdate.*' => 'required|string|max:255',
            'bt_writer.*' => 'nullable|string|max:255',
            'bt_emp_code.*' => 'nullable|string|max:255',
            'bt_two_way_emp_code.*' => 'nullable|string|max:255',
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

            $jobCard->t_writer_code = $t_writer;
            $jobCard->t_emp_code = $request['t_emp_code'][$index];
            $jobCard->t_two_way_emp_code = $request['t_two_way_emp_code'][$index];
            $jobCard->t_unit = $request['t_unit'][$index];
            $jobCard->t_pd = $request['t_pd'][$index];
            $jobCard->t_cr = $request['t_cr'][$index];
            $jobCard->t_cnc = $request['t_cnc'][$index];
            $jobCard->t_dv = $request['t_dv'][$index];
            $jobCard->t_fqc = $request['t_fqc'][$index];
            $jobCard->t_sentdate = $request['t_sentdate'][$index];
            $jobCard->bt_writer_code = $request['bt_writer'][$index] ?? null;
            $jobCard->bt_emp_code = $request['bt_emp_code'][$index] ?? null;
            $jobCard->bt_two_way_emp_code = $request['bt_two_way_emp_code'][$index] ?? null;
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

        return redirect(route('jobcardmanagement.index'))->with('message', 'Job Card created successfully.');;
    }

    public function show($id)
    {
        $jobCard = JobCard::find($id);

        if (!$jobCard) {
            return abort(403, 'Job Card not found');
        }

        return view('jobcardmanagement::show')->with('jobCard', $jobCard);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            't_writer.*' => 'required|string|max:255',
            't_emp_code.*' => 'required|string|max:255',
            't_two_way_emp_code.*' => 'required|string|max:255',
            't_unit.*'=> 'required|string|max:255',
            't_pd.*' => 'required|string|max:255',
            't_cr.*' => 'required|string|max:255',
            't_cnc.*' => 'required|string|max:255',
            't_dv.*' => 'required|string|max:255',
            't_fqc.*' => 'required|string|max:255',
            't_sentdate.*' => 'required|string|max:255',
            'bt_writer.*' => 'nullable|string|max:255',
            'bt_emp_code.*' => 'nullable|string|max:255',
            'bt_two_way_emp_code.*' => 'nullable|string|max:255',
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
            't_emp_code' => $request['t_emp_code'][$index],
            't_two_way_emp_code' => $request['t_two_way_emp_code'][$index],
            't_pd' => $request['t_pd'][$index],
            't_cr' => $request['t_cr'][$index],
            't_cnc' => $request['t_cnc'][$index],
            't_dv' => $request['t_dv'][$index],
            't_fqc' => $request['t_fqc'][$index],
            't_sentdate' => $request['t_sentdate'][$index],
            't_unit' => $request['t_unit'][$index],
            'bt_unit' => $request['bt_unit'][$index] ?? null,
            'bt_writer_code' => $request['bt_writer'][$index] ?? null,
            'bt_two_way_emp_code' => $request['bt_two_way_emp_code'][$index] ?? null,
            'bt_emp_code' => $request['bt_emp_code'][$index] ?? null,
            'bt_pd' => $request['bt_pd'][$index] ?? null,
            'bt_cr' => $request['bt_cr'][$index] ?? null,
            'bt_cnc' => $request['bt_cnc'][$index] ?? null,
            'bt_dv' => $request['bt_dv'][$index] ?? null,
            'bt_fqc' => $request['bt_fqc'][$index] ?? null,
            'bt_sentdate' => $request['bt_sentdate'][$index] ?? null,
            'job_no' => $request['job_no'][0],
            'estimate_detail_id' => $request['estimate_detail_id'][0],
            'sync_no' => $carbon,

            ]);
        }


        return redirect(route('jobcardmanagement.index'))->with('message', 'Job Card updated successfully.');;
    }

    public function edit($id){

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
        $job_register = JobRegister::where('id',$job_id)->first();
        if($job_register!=null){
            $estimate_details=EstimatesDetails::where('estimate_id',$job_register->estimate_id)->where('document_name',$job_register->estimate_document_id)->get();
            
            return view('jobcardmanagement::manage',compact('job_register','estimate_details'));
        }else{
            return abort(403, 'Job Register not found');
        }
        
    }

    public function manageDelete($job_card_id){
        $job_card = JobCard::find($job_card_id);
        if($job_card!=null){
            $job_card->delete();
            return response()->json(['success' => 'Job Card deleted successfully']);
        }else{
            return abort(403, 'Job Card not found');
        }
    }

    public function listEstimateDetailsLanguage($job_id,$estimate_detail_id){
        $estimate_detail=EstimatesDetails::where('document_name',$estimate_detail_id)->get();
        $list_estimate_language=true;
        if($estimate_detail!=null){
            return view('jobcardmanagement::manage',compact('job_id','estimate_detail','list_estimate_language'));
        }
    }

    public function billForm($job_id){
        $job=JobRegister::where('id',$job_id)->first();
        if($job->bill_date!=null){
            return view('jobcardmanagement::bill')->with('bill_data',$job);
        }
        return view('jobcardmanagement::bill')->with('job_id',$job_id);
    }

    public function addBill(Request $request,$job_id){
        $job=JobRegister::where('id',$job_id)->first();
        $job->bill_date=$request->bill_date;
        $job->bill_no=$request->bill_no;
        $job->invoice_date=$request->invoice_date;
        $job->sent_date=$request->sent_date;

        $job->po_number=$request->po_number;
        $job->delivery_date=$request->delivery_date;
        $job->payment_status=$request->payment_status;
        $job->payment_date=$request->payment_date;
        $job->save();
        return redirect(route('jobcardmanagement.index'))->with('message', 'Bill Date added successfully.');
    }

    public function updateBill(Request $request,$job_id){
        $job=JobRegister::where('id',$job_id)->first();
        $job->bill_date=$request->bill_date;
        $job->bill_no=$request->bill_no;
        $job->invoice_date=$request->invoice_date;
        $job->sent_date=$request->sent_date;
        $job->po_number=$request->po_number;
        $job->delivery_date=$request->delivery_date;
        $job->payment_status=$request->payment_status;
        $job->payment_date=$request->payment_date;
        $job->save();
        return redirect(route('jobcardmanagement.index'))->with('message', 'Bill Date updated successfully.');
    }


    public function changeStatus($id,$status){
        if(in_array($status,[0,1,2])){
            $estimate = JobRegister::where('id', $id)->first();
            $estimate->status = $status;
            $estimate->save();
            return redirect('/job-card-management');    
        }   
    }
}
