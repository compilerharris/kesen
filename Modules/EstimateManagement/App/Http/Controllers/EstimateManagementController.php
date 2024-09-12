<?php

namespace Modules\EstimateManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\ClientManagement\App\Models\Ratecard;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\LanguageManagement\App\Models\Language;

class EstimateManagementController extends Controller
{
    public function index()
    {
        $noOfDays = env('NO_OF_DAYS', 30);
        $startDate = Carbon::now()->subDays($noOfDays)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
    
        $min = request()->get('min') ? Carbon::parse(request()->get('min'))->startOfDay() : null;
        $max = request()->get('max') ? Carbon::parse(request()->get('max'))->endOfDay() : null;
    
        // Initialize query
        $query = Estimates::query()->with(['client.client_metric','client_person','employee']);
    
        // Apply date filters if present
        if ($min && $max) {
            $query->whereBetween('created_at', [$min, $max]);
        } elseif ($min) {
            $query->where('created_at', '>=', $min);
        } elseif ($max) {
            $query->where('created_at', '<=', $max);
        } else {
            if(!request()->get("reset")){
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }else{
                return redirect('/estimate-management');
            }
        }
    
        // Get filtered estimates
        $estimates = $query->orderBy('created_at', 'desc')->get();
    
        // Set default min and max for the view
        $min = $min ? $min->format('Y-m-d') : $startDate->format('Y-m-d');
        $max = $max ? $max->format('Y-m-d') : $endDate->format('Y-m-d');
    
        // Count approved and rejected estimates
        $estimates_approved_count = $estimates->where('status', 1)->count();
        $estimates_rejected_count = $estimates->where('status', 2)->count();
    
        return view('estimatemanagement::index', compact( 'estimates', 'estimates_approved_count', 'estimates_rejected_count',  'min', 'max'));
        // $noOfDays = env('NO_OF_DAYS', 30);
        // $startDate = Carbon::now()->subDays($noOfDays)->format('Y-m-d');
        // $endDate = Carbon::now()->format('Y-m-d');
        // // if(!request()->get("reset")){
        //     if(request()->get("min")&&request()->get("max")==null) {
        //         $estimates = Estimates::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->orderBy('created_at', 'desc')->get();    
        //     }elseif(request()->get("min")!=''&&request()->get("max")!='') {
        //         $estimates = Estimates::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->orderBy('created_at', 'desc')->get();    
        //     }elseif(request()->get("min")==null&&request()->get("max")){ 
        //         $estimates = Estimates::where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->orderBy('created_at', 'desc')->get();    
        //     }else{
        //         $estimates = Estimates::whereBetween('created_at',[$startDate,$endDate])->orderBy('created_at', 'desc')->get();
        //     }
        // // }else{
        // //     return redirect('/estimate-management');
        // // }

        // if(request()->get("min")==null&&request()->get("max")==null){
        //     $min = $startDate;
        //     $max = $endDate;
        // }else{
        //     $min = request()->get("min")??null;
        //     $max = request()->get("max")??null;
        // }
        // $estimates_approved_count=$estimates->where('status',1)->count();
        // $estimates_rejected_count=$estimates->where('status',2)->count();
        // return view('estimatemanagement::index')->with('estimates', $estimates)->with('estimates_approved_count', $estimates_approved_count)->with('estimates_rejected_count', $estimates_rejected_count)->with('min',$min)->with('max',$max);
    }

    public function viewPdf($id)
    {
        $estimate = Estimates::with(['client.client_metric','client_person','details.language','employee'])->where('id', $id)->first();
        $pdf = FacadePdf::loadView('estimatemanagement::pdf.estimate', ['estimate' => $estimate]);
        return $pdf->stream();
    }

    public function downloadPdf($id)
    {
        $estimate = Estimates::where('id', $id)->first();
        $pdf = FacadePdf::loadView('estimatemanagement::pdf.estimate', ['estimate' => $estimate]);
        $clientName = implode('',explode(' ',Client::where('id',$estimate->client_id)->first()->name));
        $filename = str_replace('/','-',$estimate->estimate_no) . "-" . $clientName . "-" . Carbon::parse($estimate->create_at)->format('d-m-Y') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportEstimate()
    {
        if(!request()->get("reset")){
            if(request()->get("min")&&request()->get("max")==null) {
            
                $estimates = Estimates::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->orderBy('created_at', 'desc')->get();    
            }
            elseif(request()->get("min")!=''&&request()->get("max")!='') {
                
                $estimates = Estimates::where('created_at', '>=',Carbon::parse(request()->get("min"))->startOfDay())->where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay())->orderBy('created_at', 'desc')->get();    
            }
            elseif(request()->get("min")==null&&request()->get("max")){
                
                $estimates = Estimates::where('created_at', '<=', Carbon::parse(request()->get("max"))->endOfDay()->orderBy('created_at', 'desc'))->get();    
            }else{
                $min=Carbon::now()->startOfMonth();
                $max=Carbon::now()->endOfMonth();
                $estimates = Estimates::where('created_at', '>=', $min)->where('created_at', '<=', $max)->orderBy('created_at', 'desc')->get();    
            }
        }else{
            $min=Carbon::now()->startOfMonth();
            $max=Carbon::now()->endOfMonth();
            $estimates = Estimates::where('created_at', '>=', $min)->where('created_at', '<=', $max)->orderBy('created_at', 'desc')->get();    
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
            $contact_persons = ContactPerson::where('client_id', $id)->where('status', 1)->orderBy('created_at', 'desc')->get();

            foreach ($contact_persons as $contact) {
                $html .= '<option value="' . $contact->id . '">' . $contact->name . '</option>';
            }
        }

        return response()->json(['html' => $html]);
    }


    public function create()
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
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
            'rorn' => 'required|string',
            'status' => 'nullable|in:1,0,2',
            'document_name.*' => 'required|string|max:255',
            'type.*' => 'required|string|max:255',
            'unit.*' => 'nullable|numeric',
            'rate.*' => 'nullable|numeric',
            'verification.*' => 'nullable|numeric',
            'back_translation.*' => 'nullable|numeric',
            'layout_charges.*' => 'nullable|numeric',
            'layout_charges_second.*' => 'nullable|numeric',
            'lang_*' => 'required|string',
            'two_way_qc_t.*'=>'nullable|numeric',
            'two_way_qc_bt.*'=>'nullable|numeric',
        ]);
        if ($request['document_name'] != null) {
            $estimate = new Estimates();
            $estimate->estimate_no = generateEstimateNumber($request->client_id);
            $estimate->client_id = $request->client_id;
            $estimate->client_contact_person_id = $request->client_contact_person_id;
            $estimate->headline = $request->headline;
            $estimate->type = $request->type;
            $estimate->date = $request->date;
            $estimate->currency = $request->currency;
            $estimate->status = 0;
            $estimate->discount = $request->discount ?? 0;
            $estimate->rorn = $request->rorn;
            $estimate->created_by = Auth()->user()->id;
            $estimate->updated_by = Auth()->user()->id;
            $estimate->save();
            foreach ($request['document_name'] as $index => $document_name) {
                $languages=$request['lang_' . $index];
                for ($i = 0; $i < count($languages); $i++) {
                    if(isset($languages[$i])&&$languages[$i]!=null&&$languages[$i]!=''){
                        $rateCard = Ratecard::where('client_id', $request->client_id)->where('type', $request->rorn)->where('lang', $languages[$i])->first();
                        if(isset($rateCard)){
                            // 'unit' => $request->type == "customize" ? 1 : (($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?1:$request['unit'][$index]),
                            EstimatesDetails::updateOrCreate([
                                'estimate_id' => $estimate->id,
                                'document_name' => $document_name,
                                'lang' => $languages[$i],
                                // 'unit' => $request->type == "customize" ? 1 : ($request->type == "minimum"?1:(($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?1:$request['unit'][$index])),
                                // 'rate' => $request->type == "customize" ? $rateCard->customize_rate : ($request->type == "minimum"?$rateCard->t_minimum_rate:(($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?$rateCard->t_minimum_rate:$rateCard->t_rate)),
                            ], [
                                'estimate_id' => $estimate->id,
                                'document_name' => $document_name,
                                'type' => $request->type,
                                'unit' => $request->type == "customize" ? 1 : ($request->type == "minimum"?1:(($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?1:$request['unit'][$index])),
                                'rate' => $request->type == "customize" ? $rateCard->customize_rate : ($request->type == "minimum"?$rateCard->t_minimum_rate:(($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?$rateCard->t_minimum_rate:$rateCard->t_rate)),
                                'v1' => isset($request['v_one']) && is_array($request['v_one']) && isset($request['v_one'][$index]) && $request['v_one'][$index] === 'on' ? true : false,
                                'verification' => $request->type == "customize" ? null : (isset($request['v_one']) && is_array($request['v_one']) && isset($request['v_one'][$index]) && $request['v_one'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->v1_minimum_rate:(($request['unit'][$index]*$rateCard->v1_rate) < $rateCard->v1_minimum_rate?$rateCard->v1_minimum_rate:$request['unit'][$index]*$rateCard->v1_rate)) : null),
                                'v2' => isset($request['v_two']) && is_array($request['v_two']) && isset($request['v_two'][$index]) && $request['v_two'][$index] === 'on' ? true : false,
                                'two_way_qc_t' => $request->type == "customize" ? null : (isset($request['v_two']) && is_array($request['v_two']) && isset($request['v_two'][$index]) && $request['v_two'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->v2_minimum_rate:(($request['unit'][$index]*$rateCard->v2_rate) < $rateCard->v2_minimum_rate?$rateCard->v2_minimum_rate:$request['unit'][$index]*$rateCard->v2_rate)) : null),
                                'bt' => isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? true : false,
                                'back_translation' => isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request->type == "customize" ? $rateCard->customize_rate : ($request->type == "minimum"?$rateCard->bt_minimum_rate:(($request['unit'][$index]*$rateCard->bt_rate) < $rateCard->bt_minimum_rate?$rateCard->bt_minimum_rate:$rateCard->bt_rate))) : null,
                                'btv' => isset($request['btv']) && is_array($request['btv']) && isset($request['btv'][$index]) && $request['btv'][$index] === 'on' ? true : false,
                                'verification_2' => $request->type == "customize" ? null : (isset($request['btv']) && is_array($request['btv']) && isset($request['btv'][$index]) && $request['btv'][$index] === 'on' ?  ($request->type == "minimum"?$rateCard->btv_minimum_rate:(($request['unit'][$index]*$rateCard->btv_rate) < $rateCard->btv_minimum_rate?$rateCard->btv_minimum_rate:$request['unit'][$index]*$rateCard->btv_rate)) : null),
                                'layout_charges' => $request->type == "customize" ? null : ($request['layout_charges'][$index]??null),
                                'layout_pages' => $request->type == "customize" ? null : ($request['layout_pages'][$index]??null),
                                'layout_charges_2' => $request->type == "customize" ? null : (isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request['layout_charges'][$index]??null):null),
                                'bt_layout_pages' => $request->type == "customize" ? null : (isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request['layout_pages'][$index]??null):null),
                                'lang' => $languages[$i],
                                'two_way_qc_bt' => $request['two_way_qc_bt'][$index]??null,
                            ]);
                        }else{
                            $clientName = Client::where('id',$request->client_id)->first()->name;
                            return redirect()->back()->with("alert","Please enter rates in client ".$clientName."'s Rate Card.");
                        }
                    }
                }
            }
        }else{
            return redirect()->back()->with('message', 'Please select at least one document.'); 
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

    public function changeStatus(Request $request,$id,$status){
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.');
        }
        if(in_array($status,[0,1,2])){
            $estimate = Estimates::where('id', $id)->first();
            $estimate->status = $status;
            $estimate->reject_reason = $request->reason??null;
            $estimate->save();
            $statusMsg = $status == 0? "Pending" : ($status == 1? "Approved" : "Rejected");
            Session::flash('message', 'Estimate '. $estimate->estimate_no .' status changed to '.$statusMsg.'.');
            return redirect('/estimate-management');    
        }   
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $estimate = Estimates::find($id);
        $contact_persons = ContactPerson::where('client_id', $estimate->client_id)->orderBy('created_at', 'desc')->get();
        $distinctDetails = $estimate->details()
        ->select('document_name', 'unit')
        ->distinct()
        ->get();
        // $distinctDetails = $estimate->details()
        // ->select('document_name', 'unit', 'rate')
        // ->distinct()
        // ->get();
        $estimate_details = $distinctDetails->map(function ($detail) use ($estimate) {
            $detail=$estimate->details()
                ->where('document_name', $detail->document_name)
                ->where('unit', $detail->unit)
                // ->where('rate', $detail->rate)
                ->first();
            $languages=EstimatesDetails::where('document_name', $detail->document_name)
                                                ->where('unit', $detail->unit)
                                                // ->where('rate', $detail->rate)
                                                ->get('lang')
                                                ->pluck('lang')->toArray();
            $detail->languages=$languages;
            $languagesNames=Language::whereIn('id', $languages)
                                                ->get('name')
                                                ->pluck('name')->toArray();
            $detail->languagesNames=$languagesNames;
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
            'status' => 'nullable|in:1,0,2',
            'document_name.*' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'unit.*' => 'nullable|numeric',
            'rate.*' => 'nullable|numeric',
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
        $estimate->rorn = $request->rorn;
        $estimate->currency = $request->currency;
        $estimate->status = 0;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->save();
        foreach ($request['document_name'] as $index => $document_name) {
            $languages=$request['lang_' . $index];
            // ->where('rate', $request['rate'][$index])
            $previous_lang=EstimatesDetails::where('document_name', $document_name)->where('unit', $request['unit'][$index])->where('estimate_id', $estimate->id)->get('lang')->pluck('lang')->toArray();
            $deleted_lang=array_diff($previous_lang,$languages);
            
            if(count($deleted_lang)>0){
                EstimatesDetails::where('document_name', $document_name)->where('unit', $request->type == "customize"?1:$request['unit'][$index])->where('estimate_id', $estimate->id)->whereIn('lang', $deleted_lang)->delete();
            }
            for ($i = 0; $i < count($languages); $i++) {
                if(isset($languages[$i])&&$languages[$i]!=null&&$languages[$i]!=''){
                    $rateCard = Ratecard::where('client_id', $request->client_id)->where('type', $request->rorn)->where('lang', $languages[$i])->first();
                    if(isset($rateCard)){
                        EstimatesDetails::updateOrCreate([
                            'estimate_id' => $estimate->id,
                            'document_name' => $document_name,
                            'lang' => $languages[$i],
                            // 'unit' => $request->type == "customize" ? 1 : ($request->type == "minimum"?1:(($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?1:$request['unit'][$index])),
                            // 'rate' => $request->type == "customize" ? $rateCard->customize_rate : ($request->type == "minimum"?$rateCard->t_minimum_rate:(($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?$rateCard->t_minimum_rate:$rateCard->t_rate)),
                        ], [
                            'estimate_id' => $estimate->id,
                            'document_name' => $document_name,
                            'type' => $request->type,
                            'unit' => $request->type == "customize" ? 1 : ($request->type == "minimum"?1:(($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?1:$request['unit'][$index])),
                            'rate' => $request->type == "customize" ? $rateCard->customize_rate : ($request->type == "minimum"?$rateCard->t_minimum_rate:(($request['unit'][$index]*$rateCard->t_rate) < $rateCard->t_minimum_rate?$rateCard->t_minimum_rate:$rateCard->t_rate)),
                            'v1' => isset($request['v_one']) && is_array($request['v_one']) && isset($request['v_one'][$index]) && $request['v_one'][$index] === 'on' ? true : false,
                            'verification' => $request->type == "customize" ? null : (isset($request['v_one']) && is_array($request['v_one']) && isset($request['v_one'][$index]) && $request['v_one'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->v1_minimum_rate:(($request['unit'][$index]*$rateCard->v1_rate) < $rateCard->v1_minimum_rate?$rateCard->v1_minimum_rate:$request['unit'][$index]*$rateCard->v1_rate)) : null),
                            'v2' => isset($request['v_two']) && is_array($request['v_two']) && isset($request['v_two'][$index]) && $request['v_two'][$index] === 'on' ? true : false,
                            'two_way_qc_t' => $request->type == "customize" ? null : (isset($request['v_two']) && is_array($request['v_two']) && isset($request['v_two'][$index]) && $request['v_two'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->v2_minimum_rate:(($request['unit'][$index]*$rateCard->v2_rate) < $rateCard->v2_minimum_rate?$rateCard->v2_minimum_rate:$request['unit'][$index]*$rateCard->v2_rate)) : null),
                            'bt' => isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? true : false,
                            'back_translation' => isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request->type == "customize" ? $rateCard->customize_rate : ($request->type == "minimum"?$rateCard->bt_minimum_rate:(($request['unit'][$index]*$rateCard->bt_rate) < $rateCard->bt_minimum_rate?$rateCard->bt_minimum_rate:$rateCard->bt_rate))) : null,
                            'btv' => isset($request['btv']) && is_array($request['btv']) && isset($request['btv'][$index]) && $request['btv'][$index] === 'on' ? true : false,
                            'verification_2' => $request->type == "customize" ? null : (isset($request['btv']) && is_array($request['btv']) && isset($request['btv'][$index]) && $request['btv'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->btv_minimum_rate:(($request['unit'][$index]*$rateCard->btv_rate) < $rateCard->btv_minimum_rate?$rateCard->btv_minimum_rate:$request['unit'][$index]*$rateCard->btv_rate)) : null),
                            'layout_charges' => $request->type == "customize" ? null : ($request['layout_charges'][$index]??null),
                            'layout_pages' => $request->type == "customize" ? null : ($request['layout_pages'][$index]??null),
                            'layout_charges_2' => $request->type == "customize" ? null : (isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request['layout_charges'][$index]??null):null),
                            'bt_layout_pages' => $request->type == "customize" ? null : (isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request['layout_pages'][$index]??null):null),
                            'lang' => $languages[$i],
                            'two_way_qc_bt' => $request['two_way_qc_bt'][$index]??null,
                        ]);
                    }else{
                        $clientName = Client::where('id',$request->client_id)->first()->name;
                        return redirect()->back()->with("alert","Please enter rates in client ".$clientName."'s Rate Card.");
                    }
                }
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
        if(!(Auth::user()->hasRole('Admin')||Auth::user()->hasRole('CEO'))){
            return redirect()->back()->with('alert', 'You are not autherized.'); 
        }
        $details = EstimatesDetails::where('document_name', $request->document_name)->where('estimate_id', $request->estimate_id)->get();
        if (count($details) == 0) {
            return response()->json(['success' => 'Detail not found'], 404);
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
                $html .= '<option value="'.  strval($document_name) . '">' . $document_name . '</option>';
            }
        }
        return response()->json(['html' => $html]);
    }

    // to get rate card
    public function getRatecard($clientId, $rorn, $type, $lang){
        $ratecard = Ratecard::where('client_id', $clientId)->where('type', $rorn)->where('lang', $lang)->first();
        return response()->json($ratecard);
    }
}
