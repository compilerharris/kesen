<?php

namespace Modules\EstimateManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobRegisterManagement\App\Models\JobRegister;

class EstimateManagementController extends Controller
{
    public function index()
    {
        if(!request()->get("reset")){
        if(request()->get("min")&&request()->get("max")==null) {
            
            $estimates = Estimates::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->get();    
        }
        elseif(request()->get("min")!=''&&request()->get("max")!='') {
            
            $estimates = Estimates::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->get();    
        }
        elseif(request()->get("min")==null&&request()->get("max")){
            
            $estimates = Estimates::where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->get();    
        }else{
            $min=Carbon::now()->startOfMonth();
            $max=Carbon::now()->endOfMonth();
            $estimates = Estimates::where('created_at', '>=', $min)->where('created_at', '<=', $max)->get();    
        }
    }else{
       return redirect('/estimate-management');
    }

        
        $estimates_approved_count=$estimates->where('status',1)->count();
        $estimates_rejected_count=$estimates->where('status',2)->count();
        return view('estimatemanagement::index')->with('estimates', $estimates)->with('estimates_approved_count', $estimates_approved_count)->with('estimates_rejected_count', $estimates_rejected_count);
    }

    public function viewPdf($id)
    {
        $estimate = Estimates::where('id', $id)->first();
        $pdf = FacadePdf::loadView('estimatemanagement::pdf.estimate', ['estimate' => $estimate]);
        return $pdf->stream();
    }

    public function exportEstimate()
    {
        if(!request()->get("reset")){
            if(request()->get("min")&&request()->get("max")==null) {
            
                $estimates = Estimates::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->get();    
            }
            elseif(request()->get("min")!=''&&request()->get("max")!='') {
                
                $estimates = Estimates::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->get();    
            }
            elseif(request()->get("min")==null&&request()->get("max")){
                
                $estimates = Estimates::where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->get();    
            }else{
                $min=Carbon::now()->startOfMonth();
                $max=Carbon::now()->endOfMonth();
                $estimates = Estimates::where('created_at', '>=', $min)->where('created_at', '<=', $max)->get();    
            }
        }else{
            $min=Carbon::now()->startOfMonth();
            $max=Carbon::now()->endOfMonth();
            $estimates = Estimates::where('created_at', '>=', $min)->where('created_at', '<=', $max)->get();    
        }
        $estimates_approved_count=$estimates->where('status',1)->count();
        $estimates_rejected_count=$estimates->where('status',2)->count();
        $pdf =FacadePdf::loadView('estimatemanagement::pdf.export-table-list', ['estimates'=> $estimates,'estimates_approved_count'=> $estimates_approved_count,'estimates_rejected_count'=> $estimates_rejected_count]);
        return $pdf->stream();
        
    }

    public function getContactPerson($id)
    {

        if ($id == null && $id == '') {
            $html = '<option value="">Select Contact Person</option>';
        } else {

            $html = '<option value="">Select Contact Person</option>';
            $contact_persons = ContactPerson::where('client_id', $id)->get();

            foreach ($contact_persons as $contact) {
                $html .= '<option value="' . $contact->id . '">' . $contact->name . '</option>';
            }
        }

        return response()->json(['html' => $html]);
    }


    public function create()
    {
        return view('estimatemanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'client_id' => 'required',
            'client_contact_person_id' => 'required',
            'headline' => 'nullable',
            'currency' => 'required',
            'date'=> 'required',
            'discount' => 'nullable',
            'status' => 'required|in:1,0,2',
            'document_name.*' => 'required|string|max:255',
            'type.*' => 'required|string|max:255',
            'unit.*' => 'required|numeric',
            'rate.*' => 'required|numeric',
            'verification.*' => 'nullable|numeric',
            'back_translation.*' => 'nullable|numeric',
            'layout_charges.*' => 'nullable|numeric',
            'layout_charges_second.*' => 'nullable|numeric',
            'lang_*' => 'required|string',
            'two_way_qc_t.*'=>'nullable|numeric',
            'two_way_qc_bt.*'=>'nullable|numeric',
        ]);
        $estimate = new Estimates();
        $estimate->estimate_no = generateEstimateNumber($request->client_id);
        $estimate->client_id = $request->client_id;
        $estimate->client_contact_person_id = $request->client_contact_person_id;
        $estimate->headline = $request->headline;
        $estimate->type = $request->type;
        $estimate->date = $request->date;
        $estimate->currency = $request->currency;
        $estimate->status = $request->status;
        $estimate->discount = $request->discount ?? 0;
        $estimate->created_by = Auth()->user()->id;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();
        if ($request['document_name'] != null) {
            foreach ($request['document_name'] as $index => $document_name) {
                $languages=$request['lang_' . $index];
                for ($i = 0; $i < count($languages); $i++) {
                    EstimatesDetails::create([
                        'estimate_id' => $estimate->id,
                        'document_name' => $document_name,
                        'type' => $request->type,
                        'unit' => $request['unit'][$index],
                        'rate' => $request['rate'][$index],
                        'verification' => $request['verification'][$index]??null,
                        'verification_2' => $request['verification_2'][$index]??null,
                        'back_translation' => $request['back_translation'][$index]??null,
                        'layout_charges' => $request['layout_charges'][$index]??null,
                        'layout_charges_2' => $request['layout_charges_second'][$index]??null,
                        'lang' => $languages[$i],
                        'two_way_qc_t' => $request['two_way_qc_t'][$index]??null,
                        'two_way_qc_bt' => $request['two_way_qc_bt'][$index]??null,
                    ]);
                }
                
            }
        }
        Session::flash('message', 'Estimate created successfully');
        return redirect('/estimate-management');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $estimate = Estimates::where('id', $id)->first();
        return view('estimatemanagement::pdf.estimate', ['estimate' => $estimate]);
    }

    public function changeStatus($id,$status){
        if(in_array($status,[0,1,2])){
            $estimate = Estimates::where('id', $id)->first();
            $estimate->status = $status;
            $estimate->save();
            return redirect('/estimate-management');    
        }   
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estimate = Estimates::find($id);
        $contact_persons = ContactPerson::where('client_id', $estimate->client_id)->get();
        $distinctDetails = $estimate->details()
        ->select('document_name', 'unit', 'rate')
        ->distinct()
        ->get();
        $estimate_details = $distinctDetails->map(function ($detail) use ($estimate) {
            $detail=$estimate->details()
                ->where('document_name', $detail->document_name)
                ->where('unit', $detail->unit)
                ->where('rate', $detail->rate)
                ->first();
                $languages=EstimatesDetails::where('document_name', $detail->document_name)
                                                    ->where('unit', $detail->unit)
                                                    ->where('rate', $detail->rate)
                                                    ->get('lang')
                                                    ->pluck('lang')->toArray();
            $detail->languages=$languages;
            return $detail;

        });
        return view('estimatemanagement::edit', compact('estimate', 'contact_persons', 'estimate_details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'client_id' => 'required',
            'client_contact_person_id' => 'required',
            'headline' => 'nullable',
            'date'=>'required',
            'discount' => 'nullable',
            'currency' => 'required',
            'status' => 'required|in:1,0,2',
            'document_name.*' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'unit.*' => 'required|numeric',
            'rate.*' => 'required|numeric',
            'verification.*' => 'nullable|numeric',
            'back_translation.*' => 'nullable|numeric',
            'layout_charges.*' => 'nullable|numeric',
            'layout_charges_second.*' => 'nullable|numeric',
            'lang_*' => 'required|string',
            'two_way_qc_t.*'=>'nullable|numeric',
            'two_way_qc_bt.*'=>'nullable|numeric',
        ]);

        $estimate = Estimates::find($id);
        $estimate->client_id = $request->client_id;
        $estimate->client_contact_person_id = $request->client_contact_person_id;
        $estimate->headline = $request->headline;
        $estimate->type = $request->type;
        $estimate->date = $request->date;
        $estimate->discount = $request->discount ?? 0;
        $estimate->currency = $request->currency;
        $estimate->status = $request->status;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();
        foreach ($request['document_name'] as $index => $document_name) {
            $languages=$request['lang_' . $index];
            $previous_lang=EstimatesDetails::where('document_name', $document_name)->where('unit', $request['unit'][$index])->get('lang')->pluck('lang')->toArray();
            $deleted_lang=array_diff($previous_lang,$languages);
            if(count($deleted_lang)>0){
                EstimatesDetails::where('document_name', $document_name)->where('unit', $request['unit'][$index])->whereIn('lang', $deleted_lang)->delete();
            }
                for ($i = 0; $i < count($languages); $i++) {
                    EstimatesDetails::updateOrCreate([
                        'document_name' => $document_name,
                        'unit' => $request['unit'][$index],
                        'rate' => $request['rate'][$index],
                        'lang' => $languages[$i],
                    ], [
                        'estimate_id' => $estimate->id,
                        'document_name' => $document_name,
                        'type' => $request->type,
                        'unit' => $request['unit'][$index],
                        'rate' => $request['rate'][$index],
                        'verification' => $request['verification'][$index]??null,
                        'verification_2' => $request['verification_2'][$index]??null,
                        'back_translation' => $request['back_translation'][$index]??null,
                        'layout_charges' => $request['layout_charges'][$index]??null,
                        'layout_charges_2' => $request['layout_charges_second'][$index]??null,
                        'lang' => $languages[$i],
                        'two_way_qc_t' => $request['two_way_qc_t'][$index]??null,
                        'two_way_qc_bt' => $request['two_way_qc_bt'][$index]??null,
                    ]);
        }
        
    }
        Session::flash('message', 'Estimate updated successfully');
        return redirect('/estimate-management');
    }

    public function getEstimateData($id)
    {
        $estimate = Estimates::where('id', $id)->first();
        if ($estimate != null) {
            return $estimate;
        } else {
            return false;
        }
    }
    public function deleteDetail(Request $request)
    {
        $details = EstimatesDetails::where('document_name', $request->document_name)->where('unit', $request->unit)->where('estimate_id', $request->estimate_id)->where('rate', $request->rate)->get();
        if (count($details) == 0) {
            return response()->json(['success' => 'Detail not found'], 403);
        }
        foreach ($details as $detail) {
            $detail->delete();
        }
        return response()->json(['success' => 'Detail deleted successfully']);
    }


    public function getEstimateDetails($id)
    {
        $html = '<option value="">Select Estimate Document</option>';
        if ($id == null || $id == '') {
            return response()->json(['html' => $html]);
        }
        $job_register = JobRegister::where('estimate_id', $id)->pluck('estimate_document_id');
        $estimate_details = EstimatesDetails::where('estimate_id', $id)->whereNotIn('document_name', $job_register)->distinct()->pluck('document_name');
        if (count($estimate_details) > 0) {
            $html = '<option value="">Select Estimate Document</option>';
            foreach ($estimate_details as $document_name) {
                $html .= '<option value=' . $document_name . '>' . $document_name . '</option>';
            }
        }
        return response()->json(['html' => $html]);
    }
}
