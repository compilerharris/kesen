<?php

namespace Modules\EstimateManagement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\ClientManagement\App\Models\Ratecard;
use Maatwebsite\Excel\Facades\Excel;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\EstimateManagement\App\Sheet\EstimateExport;
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
                #$query->whereBetween('created_at', [$startDate, $endDate]);
            }else{
                return redirect('/estimate-management');
            }
        }
    
        // Get filtered estimates
        $estimates = $query->orderBy('created_at', 'desc')->get();
    
        // Set default min and max for the view
        #$min = $min ? $min->format('Y-m-d') : $startDate->format('Y-m-d');
        #$max = $max ? $max->format('Y-m-d') : $endDate->format('Y-m-d');

        $min = $min ? $min->format('Y-m-d') :null;
        $max = $max ? $max->format('Y-m-d') : null;
    
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
        $query = Estimates::query()->with(['client.client_metric', 'client_person', 'details']);

        if (request()->get('min') && request()->get('max') == null) {
            $query->where('created_at', '>=', Carbon::parse(request()->get('min'))->startOfDay());
        } elseif (request()->get('min') != '' && request()->get('max') != '') {
            $query->where('created_at', '>=', Carbon::parse(request()->get('min'))->startOfDay())
                  ->where('created_at', '<=', Carbon::parse(request()->get('max'))->endOfDay());
        } elseif (request()->get('min') == null && request()->get('max')) {
            $query->where('created_at', '<=', Carbon::parse(request()->get('max'))->endOfDay());
        } else {
            $query->where('created_at', '>=', Carbon::now()->startOfMonth())
                  ->where('created_at', '<=', Carbon::now()->endOfMonth());
        }

        $estimates = $query->orderBy('created_at', 'asc')->get();
        $estimates_approved_count = $estimates->where('status', 1)->count();
        $estimates_rejected_count = $estimates->where('status', 2)->count();

        // Batch: protocol nos grouped by estimate_id (single query)
        $estimateIds = $estimates->pluck('id');
        $protocolNosMap = JobRegister::whereIn('estimate_id', $estimateIds)
            ->select(['estimate_id', 'protocol_no'])
            ->get()
            ->groupBy('estimate_id')
            ->map(fn($g) => $g->pluck('protocol_no')->filter()->implode(', '));

        // Batch: user names (single query)
        $userIds = $estimates->pluck('created_by')->unique()->filter();
        $userNames = \App\Models\User::whereIn('id', $userIds)->pluck('name', 'id');

        // Batch: EstimatesDetails counts for calculateTotalsWithCounts (single query)
        $allDetails = $estimates->flatMap(fn($e) => $e->details);
        $docNames = $allDetails->pluck('document_name')->unique()->filter()->values();
        $detailCounts = $docNames->isNotEmpty()
            ? EstimatesDetails::whereIn('document_name', $docNames)
                ->selectRaw('document_name, unit, COUNT(*) as cnt')
                ->groupBy('document_name', 'unit')
                ->get()
                ->mapWithKeys(fn($r) => [$r->document_name . '-' . $r->unit => (int) $r->cnt])
                ->all()
            : [];

        // Pre-build flat rows — no more per-row DB queries
        $rows = $estimates->map(function ($row, $index) use ($protocolNosMap, $userNames, $detailCounts) {
            $contactPerson = $row->client_person;
            $total = calculateTotalsWithCounts($row->details, $row->discount ?? 0, $detailCounts);
            return (object) [
                'sr'           => $index + 1,
                'date'         => Carbon::parse($row->created_at)->format('d-m-Y'),
                'estimate_no'  => $row->estimate_no,
                'amount'       => $total,
                'metrix'       => $row->client->client_metric->code ?? '',
                'client_name'  => $row->client->name ?? '',
                'contact_name' => $contactPerson->name ?? '',
                'contact_phone'=> $contactPerson->phone_no ?? '',
                'protocol_no'  => $protocolNosMap[$row->id] ?? '',
                'created_by'   => $userNames[$row->created_by] ?? '',
                'status'       => $row->status == 0 ? 'Pending' : ($row->status == 1 ? 'Approved' : 'Rejected'),
                'status_code'  => $row->status,
            ];
        });

        if (Auth::user()->hasRole('CEO')) {
            $pdf = FacadePdf::loadView('estimatemanagement::pdf.export-table-list', [
                'rows'                     => $rows,
                'total_count'              => $estimates->count(),
                'estimates_approved_count' => $estimates_approved_count,
                'estimates_rejected_count' => $estimates_rejected_count,
            ]);
            return $pdf->download('estimates-' . Carbon::now()->format('Y-m-d') . '.pdf');
        }

        return Excel::download(new EstimateExport($rows), 'estimates-' . Carbon::now()->format('Y-m-d') . '.xlsx');
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
            'rorn' => 'required|string|in:normal,rush',
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
            foreach ($request->input('document_name', []) as $index => $document_name) {
                if (count($this->languageIdsForDocumentRow($request, $index)) === 0) {
                    return redirect()->back()->withInput()->with('alert', 'Please select at least one language for each document row.');
                }
            }
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
            $rornKey = $this->resolveRornForRatecard($request, null);
            $estimate->rorn = $rornKey;
            $estimate->created_by = Auth()->user()->id;
            $estimate->updated_by = Auth()->user()->id;
            $estimate->save();
            foreach ($request['document_name'] as $index => $document_name) {
                $languages = $this->languageIdsForDocumentRow($request, $index);
                $postedWords = (float) ($request['unit'][$index] ?? 0);
                for ($i = 0; $i < count($languages); $i++) {
                    if(isset($languages[$i])&&$languages[$i]!=null&&$languages[$i]!=''){
                        $rateCard = $this->findRatecardForEstimateRow((string) $request->client_id, $rornKey, $languages[$i]);
                        if(isset($rateCard)){
                            $btOn = isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on';
                            [$backTranslation, $btFlatMinimum] = $this->resolveBackTranslationForDetail($rateCard, $request->type, $postedWords, $btOn);
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
                                'unit' => $request->type == "customize" ? 1 : ($request->type == "minimum"?1:(($postedWords*$rateCard->t_rate) < $rateCard->t_minimum_rate?1:$postedWords)),
                                'entered_unit' => $postedWords,
                                'rate' => $request->type == "customize" ? $rateCard->customize_rate : ($request->type == "minimum"?$rateCard->t_minimum_rate:(($postedWords*$rateCard->t_rate) < $rateCard->t_minimum_rate?$rateCard->t_minimum_rate:$rateCard->t_rate)),
                                'v1' => isset($request['v_one']) && is_array($request['v_one']) && isset($request['v_one'][$index]) && $request['v_one'][$index] === 'on' ? true : false,
                                'verification' => $request->type == "customize" ? null : (isset($request['v_one']) && is_array($request['v_one']) && isset($request['v_one'][$index]) && $request['v_one'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->v1_minimum_rate:(($postedWords*$rateCard->v1_rate) < $rateCard->v1_minimum_rate?$rateCard->v1_minimum_rate:$postedWords*$rateCard->v1_rate)) : null),
                                'v2' => isset($request['v_two']) && is_array($request['v_two']) && isset($request['v_two'][$index]) && $request['v_two'][$index] === 'on' ? true : false,
                                'two_way_qc_t' => $request->type == "customize" ? null : (isset($request['v_two']) && is_array($request['v_two']) && isset($request['v_two'][$index]) && $request['v_two'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->v2_minimum_rate:(($postedWords*$rateCard->v2_rate) < $rateCard->v2_minimum_rate?$rateCard->v2_minimum_rate:$postedWords*$rateCard->v2_rate)) : null),
                                'bt' => $btOn,
                                'back_translation' => $backTranslation,
                                'bt_flat_minimum' => $btFlatMinimum,
                                'btv' => isset($request['btv']) && is_array($request['btv']) && isset($request['btv'][$index]) && $request['btv'][$index] === 'on' ? true : false,
                                'verification_2' => $request->type == "customize" ? null : (isset($request['btv']) && is_array($request['btv']) && isset($request['btv'][$index]) && $request['btv'][$index] === 'on' ?  ($request->type == "minimum"?$rateCard->btv_minimum_rate:(($postedWords*$rateCard->btv_rate) < $rateCard->btv_minimum_rate?$rateCard->btv_minimum_rate:$postedWords*$rateCard->btv_rate)) : null),
                                'layout_charges' => $request->type == "customize" ? null : ($request['layout_charges'][$index]??null),
                                'layout_pages' => $request->type == "customize" ? null : ($request['layout_pages'][$index]??null),
                                'layout_charges_2' => $request->type == "customize" ? null : (isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request['layout_charges'][$index]??null):null),
                                'bt_layout_pages' => $request->type == "customize" ? null : (isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request['layout_pages'][$index]??null):null),
                                'lang' => $languages[$i],
                                'two_way_qc_bt' => $request->input("two_way_qc_bt.{$index}"),
                            ]);
                        }else{
                            $clientName = Client::where('id', $request->client_id)->value('name') ?? 'this client';
                            $langLabel = Language::find($languages[$i])?->name ?? (string) $languages[$i];

                            return redirect()->back()->withInput()->with(
                                'alert',
                                $this->missingRatecardUserMessage((string) $request->client_id, $clientName, $rornKey, $languages[$i], $langLabel)
                            );
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
        $estimate = Estimates::with(['client',
        'client.contact_person' => function ($query) {
            $query->orderBy('created_at', 'desc');
        },'details.language'])->find($id);
        $detailHolder = collect();

        $estimate->details->each(function ($detail) use ($detailHolder) {
            $langId = $detail->lang;
            $langName = optional($detail->language)->name ?? '';

            $key = implode('!', [(string) ($detail->document_name ?? ''), (string) ($detail->unit ?? '')]);

            $existingDetail = $detailHolder->first(function ($item) use ($key) {
                return implode('!', [(string) ($item->document_name ?? ''), (string) ($item->unit ?? '')]) === $key;
            });

            if ($existingDetail) {
                $index = $detailHolder->search(function ($item) use ($existingDetail) {
                    return $item === $existingDetail;
                });
                $languages = $existingDetail->languages;
                array_push($languages, $langId);
                $existingDetail->languages = $languages;

                $languagesNames = $existingDetail->languagesNames;
                array_push($languagesNames, $langName);
                $existingDetail->languagesNames = $languagesNames;

                $detailHolder->put($index, $existingDetail);
            } else {
                $detail->languages = [$langId];
                $detail->languagesNames = [$langName];
                $detailHolder->push($detail);
            }
        });

        if ($detailHolder->isEmpty()) {
            $placeholder = new EstimatesDetails([
                'estimate_id' => $estimate->id,
                'document_name' => '',
                'type' => $estimate->type ?? 'words',
                'unit' => null,
                'entered_unit' => null,
                'rate' => 0,
                'v1' => false,
                'v2' => false,
                'bt' => false,
                'btv' => false,
            ]);
            $placeholder->languages = [];
            $placeholder->languagesNames = [];
            $detailHolder->push($placeholder);
        }

        $estimate->eDetails = $detailHolder;
        return view('estimatemanagement::edit', compact('estimate'));
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
            'rorn' => 'required|string|in:normal,rush',
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

        foreach ($request->input('document_name', []) as $index => $document_name) {
            if (count($this->languageIdsForDocumentRow($request, $index)) === 0) {
                return redirect()->back()->withInput()->with('alert', 'Please select at least one language for each document row.');
            }
        }

        $estimate = Estimates::find($id);
        $rornKey = $this->resolveRornForRatecard($request, $estimate);
        $estimate->client_id = $request->client_id;
        $estimate->client_contact_person_id = $request->client_contact_person_id;
        $estimate->headline = $request->headline;
        $estimate->type = $request->type;
        $estimate->date = $request->date;
        $estimate->discount = $request->discount ?? 0;
        $estimate->rorn = $rornKey;
        $estimate->currency = $request->currency;
        $estimate->status = 0;
        $estimate->updated_by = Auth()->user()->id;
        $estimate->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $estimate->save();
        foreach ($request['document_name'] as $index => $document_name) {
            $languages = $this->languageIdsForDocumentRow($request, $index);
            $postedWords = (float) ($request['unit'][$index] ?? 0);
            $lookupUnit = EstimatesDetails::where('document_name', $document_name)->where('estimate_id', $estimate->id)->value('unit');
            if ($lookupUnit === null) {
                $lookupUnit = $request->type === 'customize' ? 1 : $postedWords;
            }
            $unitForRowQueries = $request->type === 'customize' ? 1 : $lookupUnit;
            // ->where('rate', $request['rate'][$index])
            $previous_lang=EstimatesDetails::where('document_name', $document_name)->where('unit', $unitForRowQueries)->where('estimate_id', $estimate->id)->get('lang')->pluck('lang')->toArray();
            $deleted_lang=array_diff($previous_lang,$languages);
            
            if(count($deleted_lang)>0){
                EstimatesDetails::where('document_name', $document_name)->where('unit', $unitForRowQueries)->where('estimate_id', $estimate->id)->whereIn('lang', $deleted_lang)->delete();
            }
            for ($i = 0; $i < count($languages); $i++) {
                if(isset($languages[$i])&&$languages[$i]!=null&&$languages[$i]!=''){
                    $rateCard = $this->findRatecardForEstimateRow((string) $request->client_id, $rornKey, $languages[$i]);
                    if(isset($rateCard)){
                        $btOn = isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on';
                        [$backTranslation, $btFlatMinimum] = $this->resolveBackTranslationForDetail($rateCard, $request->type, $postedWords, $btOn);
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
                            'unit' => $request->type == "customize" ? 1 : ($request->type == "minimum"?1:(($postedWords*$rateCard->t_rate) < $rateCard->t_minimum_rate?1:$postedWords)),
                            'entered_unit' => $postedWords,
                            'rate' => $request->type == "customize" ? $rateCard->customize_rate : ($request->type == "minimum"?$rateCard->t_minimum_rate:(($postedWords*$rateCard->t_rate) < $rateCard->t_minimum_rate?$rateCard->t_minimum_rate:$rateCard->t_rate)),
                            'v1' => isset($request['v_one']) && is_array($request['v_one']) && isset($request['v_one'][$index]) && $request['v_one'][$index] === 'on' ? true : false,
                            'verification' => $request->type == "customize" ? null : (isset($request['v_one']) && is_array($request['v_one']) && isset($request['v_one'][$index]) && $request['v_one'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->v1_minimum_rate:(($postedWords*$rateCard->v1_rate) < $rateCard->v1_minimum_rate?$rateCard->v1_minimum_rate:$postedWords*$rateCard->v1_rate)) : null),
                            'v2' => isset($request['v_two']) && is_array($request['v_two']) && isset($request['v_two'][$index]) && $request['v_two'][$index] === 'on' ? true : false,
                            'two_way_qc_t' => $request->type == "customize" ? null : (isset($request['v_two']) && is_array($request['v_two']) && isset($request['v_two'][$index]) && $request['v_two'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->v2_minimum_rate:(($postedWords*$rateCard->v2_rate) < $rateCard->v2_minimum_rate?$rateCard->v2_minimum_rate:$postedWords*$rateCard->v2_rate)) : null),
                            'bt' => $btOn,
                            'back_translation' => $backTranslation,
                            'bt_flat_minimum' => $btFlatMinimum,
                            'btv' => isset($request['btv']) && is_array($request['btv']) && isset($request['btv'][$index]) && $request['btv'][$index] === 'on' ? true : false,
                            'verification_2' => $request->type == "customize" ? null : (isset($request['btv']) && is_array($request['btv']) && isset($request['btv'][$index]) && $request['btv'][$index] === 'on' ? ($request->type == "minimum"?$rateCard->btv_minimum_rate:(($postedWords*$rateCard->btv_rate) < $rateCard->btv_minimum_rate?$rateCard->btv_minimum_rate:$postedWords*$rateCard->btv_rate)) : null),
                            'layout_charges' => $request->type == "customize" ? null : ($request['layout_charges'][$index]??null),
                            'layout_pages' => $request->type == "customize" ? null : ($request['layout_pages'][$index]??null),
                            'layout_charges_2' => $request->type == "customize" ? null : (isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request['layout_charges'][$index]??null):null),
                            'bt_layout_pages' => $request->type == "customize" ? null : (isset($request['bt']) && is_array($request['bt']) && isset($request['bt'][$index]) && $request['bt'][$index] === 'on' ? ($request['layout_pages'][$index]??null):null),
                            'lang' => $languages[$i],
                            'two_way_qc_bt' => $request->input("two_way_qc_bt.{$index}"),
                        ]);
                    }else{
                        $clientName = Client::where('id', $request->client_id)->value('name') ?? 'this client';
                        $langLabel = Language::find($languages[$i])?->name ?? (string) $languages[$i];

                        return redirect()->back()->withInput()->with(
                            'alert',
                            $this->missingRatecardUserMessage((string) $request->client_id, $clientName, $rornKey, $languages[$i], $langLabel)
                        );
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
        $ratecard = $this->findRatecardForEstimateRow((string) $clientId, strtolower(trim((string) $rorn)), $lang);

        return response()->json($ratecard);
    }

    /**
     * @return array{0: float|null, 1: bool} [back_translation, bt_flat_minimum]
     */
    private function resolveBackTranslationForDetail(Ratecard $rateCard, string $estimateType, float $enteredWords, bool $btOn): array
    {
        if (! $btOn) {
            return [null, false];
        }
        if ($estimateType === 'customize') {
            return [(float) $rateCard->customize_rate, false];
        }
        $btRate = (float) $rateCard->bt_rate;
        $btMinimum = (float) $rateCard->bt_minimum_rate;
        if (($enteredWords * $btRate) < $btMinimum) {
            return [$btMinimum, true];
        }

        return [$btRate, false];
    }

    private function resolveRornForRatecard(Request $request, ?Estimates $estimate): string
    {
        $fromRequest = $request->input('rorn');
        if (is_string($fromRequest)) {
            $fromRequest = strtolower(trim($fromRequest));
        }
        if ($fromRequest === 'normal' || $fromRequest === 'rush') {
            return $fromRequest;
        }
        $existing = $estimate?->rorn;
        if (is_string($existing)) {
            $existing = strtolower(trim($existing));
        }
        if ($existing === 'normal' || $existing === 'rush') {
            return $existing;
        }

        return 'normal';
    }

    /**
     * Resolve a rate card for pricing. Tries the given client, then any other client with the same exact name
     * (handles duplicate client rows where rate cards were saved against a different id).
     */
    private function findRatecardForEstimateRow(string $clientId, string $rorn, mixed $languageId): ?Ratecard
    {
        foreach ($this->clientIdsForSameNameGroup($clientId) as $cid) {
            $card = $this->findRatecardForExactClient($cid, $rorn, $languageId);
            if ($card !== null) {
                return $card;
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private function clientIdsForSameNameGroup(string $clientId): array
    {
        $clientId = trim((string) $clientId);
        $name = Client::query()->whereKey($clientId)->value('name');
        if ($name === null || $name === '') {
            return [$clientId];
        }

        $ids = Client::query()
            ->where('name', $name)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->unique()
            ->values()
            ->all();

        // Prefer the client currently selected on the estimate, then any same-name peer (duplicate rows).
        $rest = array_values(array_filter($ids, fn (string $id) => $id !== $clientId));

        return array_values(array_unique(array_merge([$clientId], $rest)));
    }

    private function findRatecardForExactClient(string $clientId, string $rorn, mixed $languageId): ?Ratecard
    {
        $rorn = strtolower(trim($rorn));
        $clientId = trim((string) $clientId);
        $langKey = trim((string) $languageId);

        $query = Ratecard::query()
            ->where('client_id', $clientId)
            ->where('type', $rorn);

        $card = (clone $query)->where('lang', $langKey)->first();
        if ($card) {
            return $card;
        }

        $language = Language::query()->find($langKey);
        if ($language === null) {
            return null;
        }

        $legacyKeys = array_values(array_filter(array_unique([
            trim((string) $language->name),
            trim((string) ($language->code ?? '')),
        ]), fn ($v) => $v !== '' && $v !== $langKey));

        if ($legacyKeys === []) {
            return null;
        }

        return (clone $query)->whereIn('lang', $legacyKeys)->first();
    }

    /**
     * Human-readable explanation when no rate card matches client + Rush/Normal + language.
     */
    private function missingRatecardUserMessage(
        string $clientId,
        string $clientName,
        string $rornKey,
        mixed $languageId,
        string $langLabel
    ): string {
        $langKey = trim((string) $languageId);
        $langRow = Language::query()->find($langKey);
        $langColumns = array_values(array_filter(array_unique([
            $langKey,
            $langRow ? trim((string) $langRow->name) : null,
            $langRow ? trim((string) ($langRow->code ?? '')) : null,
        ]), fn ($v) => $v !== null && $v !== ''));

        $clientIds = $this->clientIdsForSameNameGroup($clientId);

        $otherTypes = Ratecard::query()
            ->whereIn('client_id', $clientIds)
            ->whereIn('lang', $langColumns)
            ->where('type', '!=', $rornKey)
            ->distinct()
            ->pluck('type')
            ->filter()
            ->values()
            ->all();

        $msg = 'No rate card for language "'.$langLabel.'" (language id: '.$langKey.') with Rush/Normal "'.$rornKey.'". Add that combination under Client Management → Rate Cards for '.$clientName.'.';

        if (count($otherTypes) > 0) {
            $msg .= ' Note: a rate card for this language exists for '.(count($otherTypes) === 1 ? 'type' : 'types').' "'.implode('", "', $otherTypes).'" only; add "'.$rornKey.'" for this language or change the estimate Rush/Normal to match.';
        }

        if (count($clientIds) > 1) {
            $msg .= ' This client name is shared by '.count($clientIds).' client records; rate cards may be on another record with the same name—open Client Management and add the card on the client you select here, or merge duplicate clients.';
        }

        return $msg;
    }

    /**
     * Checkbox fields use name "lang_{index}[]"; normalize to a flat list of language ids.
     *
     * @return list<string|int>
     */
    private function languageIdsForDocumentRow(Request $request, int|string $index): array
    {
        return array_values(array_filter(
            Arr::wrap($request->input('lang_'.$index, [])),
            fn ($id) => $id !== null && $id !== ''
        ));
    }
}
