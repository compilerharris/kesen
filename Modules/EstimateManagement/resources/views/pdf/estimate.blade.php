<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proforma Invoice {{ $estimate->client->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 10px;
            padding: 10px;
            line-height: 0.80;
            border: 2px solid #000;
        }

        header,
        footer {
            margin-top: 5px;
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            /* Responsive table width */
            border-collapse: collapse;
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
            padding: 8px;
            font-size: 8px;
            line-height: 1;
            text-align: center;
            word-break: break-word;
            /* Prevents text from overflowing */
        }

        th {
            border: 1px solid black;
            padding: 8px;
            font-size: 8px;
            line-height: 1;
            text-align: center;
            font-size: 8px;
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
    </style>
</head>
@php $sub_total=0; @endphp

<body>
    <header>
        @if ($estimate->client->client_metric->code == 'KCP')
            <img src="{{ public_path('img/kesen-communication.jpeg') }}" alt="Kesen Communication" width="100%">
        @elseif ($estimate->client->client_metric->code == 'KLB')
            <img src="{{ public_path('img/kesen-language-buea.jpeg') }}" alt="Kesen Language Bureau" width="100%">
        @elseif ($estimate->client->client_metric->code == 'LGS')
            <img src="{{ public_path('img/kesen-linguist-system.jpeg') }}" alt="Kesen Linguist Systems" width="100%">
        @else
            <img src="{{ public_path('img/kesen-linguist-Servi-llp.jpeg') }}" alt="Kesen Linguist Services" width="100%">
        @endif

       
    </header>

    <section>
        <div style="margin-top:5px;">
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
        <p style="font-size: 12px"> <strong>{{ $estimate->client_person->name }}</strong><span style="font-size: 12px;float:right;width:300px;line-height: 1;"><strong>Ref:</strong> Quotation for {{ $estimate->headline }}</span></p>
        <p style="font-size: 12px"> <strong>{{ $estimate->client->name }}</strong></p>
        <p style="font-size: 12px">{{ $estimate->client->address }}<span style="font-size: 12px;float:right;width:300px"><strong>Mail Received on:</strong> {{ $estimate->date?\Carbon\Carbon::parse($estimate->date)->format('j M Y'):'' }}</span></p>
        <!-- <p style="font-size: 12px"><strong>Ref:</strong> Quotation for {{ $estimate->headline }}</p>
        <p style="font-size: 12px"><strong>Mail Received on:</strong> {{ $estimate->date?\Carbon\Carbon::parse($estimate->date)->format('j M Y'):'' }}</p> -->
        <p style="font-size:12px;line-height:1.6"><strong>Languages Required:</strong>
            @php $languages_list=[] @endphp
            @foreach ($estimate->details()->distinct('lang')->get() as $index=>$details )    
                @php $languages_list[]=Modules\LanguageManagement\App\Models\Language::where('id',$details->lang)->first()->name??'' @endphp
            @endforeach
            
            {{ implode(', ',array_filter(array_unique($languages_list), function($value) {return !is_null($value) && $value !== '';})) }}
        </p>
        @php $counter=6; @endphp
        <table>
            <thead>
                <tr>
                    <th>Documents</th>
                    <th>{{ ucfirst($estimate->type) }}</th>
                    <th>Rate</th>
                    <th>Translation</th>
                    @if ($estimate->details[0]->verification)
                        @php $counter=$counter+1; @endphp
                        <th>Verification</th>
                    @endif
                    @if ($estimate->details[0]->two_way_qc_t)
                        @php $counter=$counter+1; @endphp
                        <th>2 Way QC</th>
                    @endif
                    @if ($estimate->details[0]->layout_charges)
                        @php $counter=$counter+1; @endphp
                        <th>Layout Charges</th>
                    @endif
                    @if ($estimate->details[0]->back_translation)
                        @php $counter=$counter+1; @endphp
                        <th>Back Translation</th>
                    @endif
                    @if ($estimate->details[0]->verification_2)
                        @php $counter=$counter+1; @endphp
                        <th>Verification</th>
                    @endif
                    @if ($estimate->details[0]->two_way_qc_bt)
                        @php $counter=$counter+1; @endphp
                        <th>BT 2 Way QC</th>
                    @endif
                    @if ($estimate->details[0]->layout_charges_2)
                        @php $counter=$counter+1; @endphp
                        <th>Layout Charges</th>
                    @endif
                    <th style="width: 20%">Lang</th>
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
            
                    <tr>
                        <td style="width: 100px;">{{ $detail->document_name }}</td>
                        <td>{{ $detail->unit != 1 ? $detail->unit : 'Min'}}</td>
                        <td class="nowrap">{{ $detail->rate }}</td>
                        <td>{{ $detail->unit * $detail->rate }}</td>
                        @if ($estimate->details[0]->verification)
                            <td>{{ $detail->verification }}</td>
                        @endif
                        @if ($estimate->details[0]->two_way_qc_t)
                            <td>{{ $detail->two_way_qc_t }}</td>
                        @endif
                        @if ($estimate->details[0]->layout_charges)
                            <td style="width: 50px;">{{ "Rs. ".$detail->layout_charges."x".$detail->layout_pages."pgs = Rs. ".($detail->layout_pages*$detail->layout_charges)."/-" }}</td>
                        @endif
                        @if ($estimate->details[0]->back_translation)
                            <td>{{ $detail->back_translation*$detail->unit }}</td>
                        @endif
                        @if ($estimate->details[0]->verification_2)
                            <td>{{ $detail->verification_2 }}</td>
                        @endif
                        @if ($estimate->details[0]->two_way_qc_bt)
                            <td>{{ $detail->two_way_qc_bt }}</td>
                        @endif
                        @if ($estimate->details[0]->layout_charges_2)
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
                    <td colspan="1" style="font-size: 8px;font-weight: bold">{{ number_format($sub_total,2) }}</td>
                </tr>
                @if ($estimate->discount)
                    <tr class="financials">
                        <td colspan="{{ $counter - 1 }}">Discount</td>
                        <td colspan="1" style="font-size: 6px;">{{ number_format($estimate->discount,2) ?? 0 }}</td>
                    </tr>
                    <tr class="financials" style="background-color: #f0f0f0">
                        <td colspan="{{ $counter - 1 }}"><strong>Gross Total</strong></td>
                        <td colspan="1" style="font-size: 6px;"><strong>{{  number_format(($sub_total - $estimate->discount),2) }}</strong></td>
                    </tr>
                @endif
                @php $net_total=($sub_total-($estimate->discount)) @endphp
                <tr class="financials">
                    <td colspan="{{ $counter - 1 }}">GST (18%)</td>
                    <td colspan="1" style="font-size: 6px;">{{ number_format(($net_total / 100) * 18 ,2) }}</td>
                </tr>
                <tr class="financials" style="background-color: #f0f0f0">
                    <td colspan="{{ $counter - 1 }}" style="font-size: 14px;font-weight: bold">Net Total</td>
                    <td colspan="1" style="font-size: 6px;font-weight: bold">{{ number_format(($net_total + ($net_total / 100) * 18),2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <footer style="text-align: left;float: left;">
        <p style="font-weight: bold;font-size: 12px">SAC Code: 998395</p>
        <p style="font-weight: bold;font-size: 12px">PS: TAXES AS APPLICABLE FROM TIME TO TIME.</p>
        <p style="font-size: 12px">The Job will be completed as per TAT provided.</p>
        <p style="font-size: 12px">Kindly let us have your approval.</p>
        <p style="font-size: 12px"> In case you need any clarification, please do not hesitate to call the undersigned.
        </p>
        <p style="font-size: 12px">Assuring you of our best services at all times.</p><br>
        <div>
            <div style="display: block">
                <p style="display: inline">For </p>
                <p style="font-weight: bold;display: inline">{{ $estimate->client->client_metric->name }}</p>
            </div>
            @if (in_array(Auth::user()->code,['RIT','SHA','ANG']))
                <img src="{{ public_path('img/'.Auth::user()->code.'.png') }}" alt="{{Auth::user()->name}}" width="120px" style="margin-left:20px;margin-bottom:-10px;">
            @else
                <div style="height: 50px;"></div>
            @endif
            <div>
                _________________________
            </div>
            <br>
            <div >
                <span style="display: inline;padding-left: 35px;"><strong>Authorized Signatory</strong></span>
                <span style="float: right;font-weight: bold;font-size: 12px;display: inline">Help us to Serve you Better
                </span>
            </div>
        </div>
    </footer>
</body>

</html>
