<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proforma Invoice {{ $estimate->client->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 8px;
            line-height: 0.80;
            border: 2px solid #000;
        }

        header{
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
        footer {
            margin-top: 5px;
            width: 100%;
            text-align: center;
        }

        table {
            width: 100%;
            /* Responsive table width */
            border-collapse: collapse;
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
            padding: 5px;
            font-size: 8px;
            line-height: 1;
            text-align: center;
            word-break: break-word;
            /* Prevents text from overflowing */
        }

        th {
            border: 1px solid black;
            padding: 5px;
            font-size: 8px;
            line-height: 1;
            text-align: center;
            font-size: 10px;
            background-color: #f2f2f2;
        }

        .header-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .sub-title {
            width: 100px;
            background-color: #c1c1c1;
            padding: 10px;
            font-size: 18px;
        }

        .right-align {
            text-align: right;
        }

        .center-text {
            text-align: center;
        }

        .financials td {
            text-align: center;
            /* Aligns numbers to the right for better readability */
        }

        .nowrap {
            white-space: nowrap;
            /* Prevents text from wrapping */
        }
        p {
            line-height: .5;
        }
        .mainTable > td{
            font-size: 11px;
        }
        .heading-section{
            margin-bottom: 5px;
            border: 0;
        }
        .heading-section tr td{
            text-align: left;
            font-size: 12px;
            border: 0;
            padding: 3px 0;
        }
    </style>
</head>
@php $sub_total=0; @endphp

<body>
    <header>
        @if ($estimate->client->client_metric->code == 'KCP')
            <img src="{{ public_path('img/kesen-communication.png') }}" alt="Kesen Communication" width="100%">
        @elseif ($estimate->client->client_metric->code == 'KLB')
            <img src="{{ public_path('img/kesen-language-buea.png') }}" alt="Kesen Language Bureau" width="100%">
        @elseif ($estimate->client->client_metric->code == 'LGS')
            <img src="{{ public_path('img/kesen-linguist-system.png') }}" alt="Kesen Linguist Systems" width="100%">
        @else
            <img src="{{ public_path('img/kesen-linguist-Servi-llp.png') }}" alt="Kesen Linguist Services" width="100%">
        @endif
    </header>

    <section>
        <div>
            <div class="right-align" style="font-weight: bold;">F/P/7.2.3</div>
        </div>
        <div style="margin-top: 10px;margin-bottom: 10px">
            <span style="display: inline;font-weight: bold;">No: {{ $estimate->estimate_no }}</span>
            <span class="sub-title" style="margin-left: 13%;font-weight: bold;" >PROFORMA</span>
            <span style="float: right;font-weight: bold;font-size: 16px;display: inline">Date: {{ $estimate->created_at->format('j M Y') }}</span>
        </div>
        
        <div>
            <hr style="opacity: 0.5;">
        </div>
        <table class="heading-section" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="width: 60%;vertical-align: top;"><strong>{{ $estimate->client_person->name }}</strong></td>
                <td style="width: 40%"><strong>Ref:</strong> Quotation for {{ $estimate->headline }}</td>
            </tr>
            <tr>
                <td><strong>{{ $estimate->client->name }}</td>
                <td><strong>Mail Received on:</strong> {{ $estimate->date?\Carbon\Carbon::parse($estimate->date)->format('j M Y'):'' }}</td>
            </tr>
            <tr>
                <td style="line-height: 1">{{ $estimate->client->address }}</td>
            </tr>
            <tr>
                <td style="line-height: 1.5" colspan="2"><strong>Languages Required:</strong>
                    @php $languages_list=collect(); @endphp
                    @foreach ($estimate->details()->distinct('lang')->get() as $index=>$details )    
                        @php 
                            $languages_list->push(Modules\LanguageManagement\App\Models\Language::where('id',$details->lang)->first()??'');
                        @endphp
                    @endforeach
                    @php 
                        $languages_list = sort_languages($languages_list)->pluck('name')->toArray();
                    @endphp
                    
                    {{ implode(', ',array_filter(array_unique($languages_list), function($value) {return !is_null($value) && $value !== '';})) }}</td>
            </tr>
        </table>
        {{-- <p style="font-size: 12px"><strong>{{ $estimate->client_person->name }}</strong>
            <span style="font-size: 12px;float:right;width:300px;line-height: 1;"><strong>Ref:</strong> Quotation for {{ $estimate->headline }}</span>
        </p> --}}
        {{-- <p style="font-size: 12px"><strong>{{ $estimate->client->name }}</strong>
        </p>
        <p>
            <span style="font-size: 12px;float: left;">{{ $estimate->client->address }}</span>
            <span style="font-size: 12px;float:right;width:300px;height: auto;"><strong>Mail Received on:</strong> {{ $estimate->date?\Carbon\Carbon::parse($estimate->date)->format('j M Y'):'' }}</span>
        </p> --}}
        {{-- <p style="font-size: 12px"><strong>Ref:</strong> Quotation for {{ $estimate->headline }}</p>
        <p style="font-size: 12px"><strong>Mail Received on:</strong> {{ $estimate->date?\Carbon\Carbon::parse($estimate->date)->format('j M Y'):'' }}</p> --}}
        {{-- <p style="font-size:12px;line-height:0.5"><strong>Languages Required:</strong>
            @php $languages_list=collect(); @endphp
            @foreach ($estimate->details()->distinct('lang')->get() as $index=>$details )    
                @php 
                    $languages_list->push(Modules\LanguageManagement\App\Models\Language::where('id',$details->lang)->first()??'');
                @endphp
            @endforeach
            @php 
                $languages_list = sort_languages($languages_list)->pluck('name')->toArray();
            @endphp
            
            {{ implode(', ',array_filter(array_unique($languages_list), function($value) {return !is_null($value) && $value !== '';})) }}
        </p> --}}
        @php 
            $counter=6;
            $filteredV1 = array_filter($estimate->details->pluck('v1')->toArray(), function($value) {
                return $value != false;
            });
            $filteredV2 = array_filter($estimate->details->pluck('v2')->toArray(), function($value) {
                return $value != false;
            });
            $filteredLayout = array_filter($estimate->details->pluck('layout_charges')->toArray(), function($value) {
                return $value != null;
            });
            $filteredBt = array_filter($estimate->details->pluck('bt')->toArray(), function($value) {
                return $value != null;
            });
            $filteredBtv = array_filter($estimate->details->pluck('btv')->toArray(), function($value) {
                return $value != null;
            });
            $filteredBtLayout = array_filter($estimate->details->pluck('layout_charges_2')->toArray(), function($value) {
                return $value != null;
            });
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Documents</th>
                    <th>{{ $estimate->type == 'customize'?'Words':ucfirst($estimate->type) }}</th>
                    <th>Rate</th>
                    <th>Translation</th>
                    @if (count($filteredV1)>0)
                        @php $counter=$counter+1; @endphp
                        <th>Verification</th>
                    @endif
                    @if (count($filteredV2)>0)
                        @php $counter=$counter+1; @endphp
                        <th>2 Way QC</th>
                    @endif
                    @if (count($filteredLayout)>0)
                        @php $counter=$counter+1; @endphp
                        <th class="nowrap">Layout Charges</th>
                    @endif
                    @if (count($filteredBt)>0)
                        @php $counter=$counter+1; @endphp
                        <th>Back Translation</th>
                    @endif
                    @if (count($filteredBtv)>0)
                        @php $counter=$counter+1; @endphp
                        <th>Verification</th>
                    @endif
                    @if ($estimate->details[0]->two_way_qc_bt)
                        @php $counter=$counter+1; @endphp
                        <th>BT 2 Way QC</th>
                    @endif
                    @if (count($filteredBtLayout)>0)
                        @php $counter=$counter+1; @endphp
                        <th class="nowrap">Layout Charges</th>
                    @endif
                    <th style="width: 20%">No. of Languages</th>
                    <th style="width: 20%">Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody>@php
                $uniqueDetails = collect();
            @endphp
            
            @foreach ($estimate->details as $detail)
                @php
                    $combination = $detail->document_name . '-' . $detail->unit.'-'.$detail->rate;
                @endphp
            
                @if (!$uniqueDetails->contains($combination))
                    @php
                        $uniqueDetails->push($combination);
                    @endphp
            
                    <tr class="mainTable">
                        <td style="width: 100px;">{{ $detail->document_name }}</td>
                        <td>{{ $detail->unit != 1 ? $detail->unit : 'Min'}}</td>
                        <td class="nowrap">{{ $detail->rate }}</td>
                        <td>{{ $detail->unit * $detail->rate }}</td>
                        @if (count($filteredV1)>0)
                            <td>{{ $detail->verification }}</td>
                        @endif
                        @if (count($filteredV2)>0)
                            <td>{{ $detail->two_way_qc_t }}</td>
                        @endif
                        @if (count($filteredLayout)>0)
                            <td style="width: 50px;">{{ "Rs. ".$detail->layout_charges."x".$detail->layout_pages."pgs = Rs. ".($detail->layout_pages*$detail->layout_charges)."/-" }}</td>
                        @endif
                        @if (count($filteredBt)>0)
                            <td>{{ $detail->back_translation*$detail->unit }}</td>
                        @endif
                        @if (count($filteredBtv)>0)
                            <td>{{ $detail->verification_2 }}</td>
                        @endif
                        @if ($estimate->details[0]->two_way_qc_bt)
                            <td>{{ $detail->two_way_qc_bt }}</td>
                        @endif
                        @if (count($filteredBtLayout)>0)
                            <td style="width: 50px;">{{ "Rs. ".$detail->layout_charges_2."x".$detail->bt_layout_pages."pgs = Rs. ".($detail->bt_layout_pages*$detail->layout_charges_2)."/-" }}</td>
                        @endif
                        @php 
                            $languages_ids=Modules\EstimateManagement\App\Models\EstimatesDetails::where('document_name', $detail->document_name)->where('unit', $detail->unit)->where('rate', $detail->rate)->get('lang')->pluck('lang')
                        @endphp
                        <td>{{ Modules\LanguageManagement\App\Models\Language::whereIn('id', $languages_ids)->pluck('code')->implode('/') }}</td>
                        <td class="nowrap">
                            {{ number_format( (($detail->unit * $detail->rate) + ($detail->layout_charges?($detail->layout_pages*$detail->layout_charges):0) + ($detail->unit*($detail->back_translation??0)) + ($detail->verification??0) + ($detail->two_way_qc_t??0) + ($detail->two_way_qc_bt??0) + ($detail->verification_2??0) + ($detail->layout_charges_2?($detail->bt_layout_pages*$detail->layout_charges_2):0) ) * (Modules\EstimateManagement\App\Models\EstimatesDetails::where('estimate_id', $detail->estimate_id)->where('document_name', $detail->document_name)->where('unit', $detail->unit)->where('rate', $detail->rate)->count()),2) }}
                        </td>
                        @php
                            $sub_total = ($sub_total + (($detail->unit * $detail->rate) + ($detail->layout_charges?($detail->layout_pages*$detail->layout_charges):0) +  ($detail->unit*($detail->back_translation??0)) + ($detail->verification) + ($detail->two_way_qc_t) + ($detail->two_way_qc_bt) + ($detail->verification_2) + ($detail->layout_charges_2?($detail->bt_layout_pages*$detail->layout_charges_2):0)) * (Modules\EstimateManagement\App\Models\EstimatesDetails::where('estimate_id', $detail->estimate_id)->where('document_name', $detail->document_name)->where('unit', $detail->unit)->where('rate', $detail->rate)->count()));
                        @endphp
                    </tr>
                @endif
            @endforeach
            
                <tr class="financials" style="background-color: #f0f0f0">
                    <td colspan="{{ $counter - 1 }}" style="font-size: 12px;font-weight: bold">Sub Total</td>
                    <td colspan="1" style="font-size: 9px;font-weight: bold">{{ number_format($sub_total,2) }}</td>
                </tr>
                @if ($estimate->discount)
                    <tr class="financials">
                        <td colspan="{{ $counter - 1 }}" style="font-size: 10px;">Discount</td>
                        <td colspan="1" style="font-size: 8px;">{{ number_format($estimate->discount,2) ?? 0 }}</td>
                    </tr>
                    <tr class="financials" style="background-color: #f0f0f0">
                        <td colspan="{{ $counter - 1 }}" style="font-size: 12px;"><strong>Gross Total</strong></td>
                        <td colspan="1" style="font-size: 9px;"><strong>{{  number_format(($sub_total - $estimate->discount),2) }}</strong></td>
                    </tr>
                @endif
                @php $net_total=($sub_total-($estimate->discount)) @endphp
                <tr class="financials">
                    <td colspan="{{ $counter - 1 }}">GST (18%)</td>
                    <td colspan="1" style="font-size: 8px;">{{ number_format(($net_total / 100) * 18 ,2) }}</td>
                </tr>
                <tr class="financials" style="background-color: #f0f0f0">
                    <td colspan="{{ $counter - 1 }}" style="font-size: 14px;font-weight: bold">Net Total</td>
                    <td colspan="1" style="font-size: 9px;font-weight: bold">{{ number_format(($net_total + ($net_total / 100) * 18),2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <footer style="text-align: left;float: left;">
        <p style="font-weight: bold;font-size: 8px; line-height: 0.2;">SAC Code: 998395</p>
        <p style="font-weight: bold;font-size: 8px; line-height: 0.2;">PS: TAXES AS APPLICABLE FROM TIME TO TIME.</p>
        <p style="font-size: 8px; line-height: 0.2;">The Job will be completed as per TAT provided.</p>
        <p style="font-size: 8px; line-height: 0.2;">Kindly let us have your approval.</p>
        <p style="font-size: 8px; line-height: 0.2;"> In case you need any clarification, please do not hesitate to call the undersigned.
        </p>
        <p style="font-size: 8px; line-height: 0.2;">Assuring you of our best services at all times.</p>
        <div>
            <div style="display: block;font-size: 12px;">
                <p style="display: inline">For </p>
                <p style="font-weight: bold;display: inline">{{ $estimate->client->client_metric->name }}</p>
            </div>
            @if (file_exists(public_path('img/'.\App\Models\User::where('id',$estimate->created_by)->first()->code.'.png')))
                <img src="{{ public_path('img/'.\App\Models\User::where('id',$estimate->created_by)->first()->code.'.png') }}" alt="{{Auth::user()->name}}" width="120px" style="margin-left:20px;margin-bottom:-10px;">
            @else
                <div style="height: 50px;"></div>
            @endif
            <div style="margin-bottom: 5px;">
                _________________________
            </div>
            <div >
                <span style="display: inline;padding-left: 35px;font-size: 12px"><strong>Authorized Signatory</strong></span>
                <span style="float: right;font-weight: bold;font-size: 12px;display: inline">Help us to Serve you Better
                </span>
            </div>
        </div>
    </footer>
</body>

</html>
