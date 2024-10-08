<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesen Language Bureau Job Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt; /* Adjusted for better PDF rendering */
        }

        .container {
            width: 100%;
            margin: 0px auto;
            box-sizing: border-box;
        }

        .header{
            text-align: center;
            padding-bottom: 10px;
        }

        .footer {
            text-align: center;
            padding: 10px 0;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .client-info th,
        .client-info td,
        .job-details th,
        .job-details td,
        .additional-info th,
        .additional-info td {
            border: 1px solid #000;
            padding:2px;
            word-wrap: break-word;
        }

        .job-details th,
        .client-info th,
        .additional-info th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .client-info td,
        .job-details td,
        .additional-info td {
            text-align: left;
        }

        .job-details th, 
        .job-details td {
            font-size: 8pt;
            text-align: center;
            padding: 4px 2px;
        }

        .additional-info td {
            font-size: 8pt;
        }

        @page {
            margin: 20px;
        }

        /* PDF-specific styles */
        @media print {
            body {
                font-size: 10pt;
            }
            
            .container {
                margin: 0;
            }

            .header,
            .footer {
                padding: 0;
            }

            .client-info th,
            .client-info td,
            .job-details th,
            .job-details td,
            .additional-info th,
            .additional-info td {
                padding: 5px;
            }
        }
        .page-break {
            page-break-before: always;
        }
        .client-info td{
            padding-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if (($job->estimate?$job->estimate->client->client_metric->code:($job->no_estimate->client->client_metric->code??'')) == 'KCP')
                <img src="{{ public_path('img/kesen-communication.jpg') }}" alt="Kesen Communication" width="100%">
            @elseif (($job->estimate?$job->estimate->client->client_metric->code:($job->no_estimate->client->client_metric->code??'')) == 'KLB')
                <img src="{{ public_path('img/kesen-language-buea.jpg') }}" alt="Kesen Language Bureau" width="100%">
            @elseif (($job->estimate?$job->estimate->client->client_metric->code:($job->no_estimate->client->client_metric->code??'')) == 'LGS')
                <img src="{{ public_path('img/kesen-linguist-system.jpg') }}" alt="Kesen Linguist System" width="100%">
            @else
                <img src="{{ public_path('img/kesen-linguist-servi-llp.jpg') }}" alt="Kesen Linguist Servi LLP" width="100%">
            @endif
            <h2 style="margin:5px 0px">JOB CARD</h2>
        </div>
        <table class="client-info" style="margin-bottom: 5px;">
            <tr>
                <th>Client</th>
                <td style="font-size:25px"><b>{{ $job->estimate?$job->estimate->client->name:($job->no_estimate?$job->no_estimate->client->name: '') }}</b></td>
                <th>Job No.</th>
                <td style="font-size:25px"><b>{{ $job->sr_no ?? '' }}</b></td>
            </tr>
            <tr>
                <th>Document Name</th>
                <td><b>{{ $job->estimate_document_id ?? '' }}</b></td>
                <th>Date</th>
                <td><b>{{ $job->date ? \Carbon\Carbon::parse($job->created_at)->format('j M Y') : '' }}</b></td>
            </tr>
            <tr>
                <th>Job Type</th>
                <td><b>{{isset($job->type)?ucwords(str_replace("-"," ",$job->type)):''}}</b></td>
                <th>Protocol No.</th>
                <td>{{ $job->protocol_no ?? '' }}</td>
            </tr>
            <tr>
                <th>Ver. no. / Date</th>
                <td><b>{{ $job->version_no?? '' }} {{$job->version_no&&$job->version_date?' / ':''}} {{ $job->version_date&&$job->version_date!='0000-00-00' ? \Carbon\Carbon::parse($job->version_date)->format('j M Y') : '' }}</b></td>
                <th>Contact Name</th>
                <td><b>{{ $job->estimate?$job->estimate->client_person->name:($job->no_estimate->client_person->name?? '') }}</b></td>
            </tr>
            <tr>
                <th>Estimate No.</th>
                <td>{{ $job->estimate?$job->estimate->estimate_no:($job->no_estimate?'No Estimate':'') }}</td>
                <th>Contact Number</th>
                <td>{{ $job->estimate?$job->estimate->client_person->phone_no:($job->no_estimate->client_person->phone_no??'') }}</td>
            </tr>
            <tr>
                <th>Add. Estimate No.</th>
                <td>{{ $job->other_details!=null?\Modules\EstimateManagement\App\Models\Estimates::whereIn('id', explode(',', $job->other_details))->get()->pluck('estimate_no')->implode(', ') ?? '':"" }}</td>
                <th>Project Manager</th>
                <td style="font-size:18px;"><b>{{ $job->handle_by->name ?? '' }}</b></td>
            </tr>
        </table>
        <table class="job-details">
            <thead>
                <tr>
                    <th colspan="3">Langs.</th>
                    <th>Unit</th>
                    <th>Writer Code</th>
                    <th>Employee Code</th>
                    {{-- <th>Two Way QC Verified By</th> --}}
                    <th>PD</th>
                    <th>CR</th>
                    <th>C/NC</th>
                    <th>DV</th>
                    <th>F/QC</th>
                    <th>Sent Date</th>
                </tr>
            </thead>
            <tbody>
                @php $estimate_details_list=[];@endphp
                @php $temp_index=1;@endphp
                @php $pageBreakIndex=0;@endphp
                @php $lanIndex=0;@endphp
                @php
                    $estimates = $job->estimate?$job->estimate->details:$job->no_estimate->details;
                    $estimates = $estimates->filter(function ($estimate) use ($job) {
                        return $estimate->document_name == $job->estimate_document_id;
                    });
                    $estimates = sort_languages_job_card_preview($estimates);
                @endphp
                @foreach($estimates as $index => $estimate)
                    @php $partCopyIndex = $estimate->jobCards->count(); @endphp
                    @if($partCopyIndex > 0)
                        @php $lanRowCount = $partCopyIndex; @endphp
                        @foreach($estimate->jobCards as $cardIndex => $card)
                            {{-- t --}}
                            <tr style="{{$cardIndex==0?'border-top: solid 2px #000':''}}">
                                @if($lanRowCount == $partCopyIndex)
                                    @php $lanIndex = $lanIndex==0?1:0;@endphp
                                    <td rowspan="5" style={{$lanIndex == 0?"background-color:#fff;width:50px":"background-color:lightgrey;width:50px;border-top:2px"}}><b>{{ $estimate->language->name }}</b></td>
                                @else
                                    <td rowspan="5" style={{$lanIndex == 0?"background-color:#fff;width:50px;border-top-style:hidden;":"background-color:lightgrey;width:50px;border-top:2px;border-top-style:hidden;"}}></td>
                                @endif
                                @php $lanRowCount--; @endphp
                                <td rowspan="5">PC {{$partCopyIndex==1?'':$cardIndex + 1}}</td>
                                <td style="font-size: 8pt;{{$estimate->t?'background-color:grey;':''}}">T</td>
                                <td>{{ $card->t_unit }}</td>
                                <td>{{ Modules\WriterManagement\App\Models\Writer::where('id', $card->t_writer_code)->first()->code??'' }}</td>
                                <td></td>
                                
                                <td>{{ $card->t_pd ? \Carbon\Carbon::parse($card->t_pd)->format('j M Y') : '' }}</td>
                                <td>{{ $card->t_cr ? \Carbon\Carbon::parse($card->t_cr)->format('j M Y') : '' }}</td>
                                <td>{{ $card->t_writer_code?$card->t_cnc:'' }}</td>
                                <td>{{ $estimate->t && $card->t_dv!=null? (App\Models\User::where('id', $card->t_dv)->first()->code??''):''  }}</td>
                                <td>{{ $estimate->t && $card->t_fqc!=null? App\Models\User::where('id', $card->t_fqc)->first()->code??$card->t_fqc:''  }}</td>
                                <td>{{ $estimate->t && $card->t_sentdate ? \Carbon\Carbon::parse($card->t_sentdate)->format('j M Y') : '' }}</td>
                            </tr>
                            {{-- v1 --}}
                            <tr>
                                <td style="font-size: 8pt;{{$card->v_employee_code?'background-color:#f5f5f5;':''}}">V</td>
                                <td>{{ $card->v_unit }}</td>
                                <td></td>
                                <td>{{ App\Models\User::where('id', $card->v_employee_code)->first()->code ??(Modules\WriterManagement\App\Models\Writer::where('id', $card->v_employee_code)->first()->code??'') }}</td>
                                
                                <td>{{ $card->v_pd ? \Carbon\Carbon::parse($card->v_pd)->format('j M Y') : '' }}</td>
                                <td>{{ $card->v_cr ? \Carbon\Carbon::parse($card->v_cr)->format('j M Y') : '' }}</td>
                                <td>{{ $card->v_cnc }}</td>
                                <td>{{ $card->v_dv }}</td>
                                <td>{{ $card->v_fqc!=null? App\Models\User::where('id', $card->v_fqc)->first()->code??'':'' }}</td>
                                <td>{{ $card->v_sentdate ? \Carbon\Carbon::parse($card->v_sentdate)->format('j M Y') : '' }}</td>
                            </tr>
                            {{-- v2 --}}
                            <tr>
                                <td style="font-size: 8pt;{{$card->v2_employee_code?'background-color:#f5f5f5;':''}}">V2</td>
                                <td>{{ $card->v2_unit }}</td>
                                <td></td>
                                <td>{{ App\Models\User::where('id', $card->v2_employee_code)->first()->code ?? '' }}</td>
                                
                                <td>{{ $card->v2_pd ? \Carbon\Carbon::parse($card->v2_pd)->format('j M Y') : '' }}</td>
                                <td>{{ $card->v2_cr ? \Carbon\Carbon::parse($card->v2_cr)->format('j M Y') : '' }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            {{-- bt --}}
                            <tr>
                                <td style="font-size: 8pt;{{$estimate->bt?'background-color:grey;':''}}">BT</td>
                                <td>{{ $card->bt_unit }}</td>
                                <td>{{ Modules\WriterManagement\App\Models\Writer::where('id', $card->bt_writer_code)->first()->code ?? '' }}</td>
                                <td></td>
                                
                                <td>{{ $card->bt_pd ? \Carbon\Carbon::parse($card->bt_pd)->format('j M Y') : '' }}</td>
                                <td>{{ $card->bt_cr ? \Carbon\Carbon::parse($card->bt_cr)->format('j M Y') : '' }}</td>
                                <td>{{ $card->estimateDetail->bt?$card->bt_cnc:'' }}</td>
                                <td>{{ $estimate->bt && $card->bt_dv!=null? App\Models\User::where('id', $card->bt_dv)->first()->code??'':'' }}</td>
                                <td>{{ $estimate->bt && $card->bt_fqc!=null? App\Models\User::where('id', $card->bt_fqc)->first()->code??$card->bt_fqc:''  }}</td>
                                <td>{{ $estimate->bt && $card->bt_writer_code ? ($card->bt_sentdate ? \Carbon\Carbon::parse($card->bt_sentdate)->format('j M Y') : ''):'' }}</td>
                            </tr>
                            {{-- btv --}}
                            <tr>
                                <td style="font-size: 8pt;{{$estimate->btv?'background-color:#f5f5f5;':''}}">BTV</td>
                                <td>{{ $card->btv_unit }}</td>
                                <td></td>
                                <td>{{ App\Models\User::where('id', $card->btv_employee_code)->first()->code ?? (Modules\WriterManagement\App\Models\Writer::where('id', $card->btv_employee_code)->first()->code??'') }}</td>
                                <td>{{ $card->btv_pd ? \Carbon\Carbon::parse($card->btv_pd)->format('j M Y') : '' }}</td>
                                <td>{{ $card->btv_cr ? \Carbon\Carbon::parse($card->btv_cr)->format('j M Y') : '' }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php $pageBreakIndex+=5;@endphp
                            @if($index < $estimates->count()-1)
                                @if($pageBreakIndex % 30 == 0 && $pageBreakIndex == 30 )
                                        </tbody>
                                    </table>
                                    <div class="page-break"></div>
                                    <table class="job-details">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Langs.</th>
                                                <th>Unit</th>
                                                <th>Writer Code</th>
                                                <th>Employee Code</th>
                                                <th>PD</th>
                                                <th>CR</th>
                                                <th>C/NC</th>
                                                <th>DV</th>
                                                <th>F/QC</th>
                                                <th>Sent Date</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                @elseif($pageBreakIndex % 75 == 0 && $pageBreakIndex == 75 )
                                        </tbody>
                                    </table>
                                    <div class="page-break"></div>
                                    <table class="job-details">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Langs.</th>
                                                <th>Unit</th>
                                                <th>Writer Code</th>
                                                <th>Employee Code</th>
                                                <th>PD</th>
                                                <th>CR</th>
                                                <th>C/NC</th>
                                                <th>DV</th>
                                                <th>F/QC</th>
                                                <th>Sent Date</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                @elseif($pageBreakIndex % 75 == 0 && $pageBreakIndex > 75 )
                                        </tbody>
                                    </table>
                                    <div class="page-break"></div>
                                    <table class="job-details">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Langs.</th>
                                                <th>Unit</th>
                                                <th>Writer Code</th>
                                                <th>Employee Code</th>
                                                <th>PD</th>
                                                <th>CR</th>
                                                <th>C/NC</th>
                                                <th>DV</th>
                                                <th>F/QC</th>
                                                <th>Sent Date</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                @endif
                            @endif
                        @endforeach
                    @else
                        {{-- t --}}
                        <tr style="border-top: solid 3px #000">
                            @php $lanIndex = $lanIndex==0?1:0;@endphp
                            <td rowspan="5" style={{$lanIndex == 0?"background-color:#fff;width:50px":"background-color:lightgrey;width:50px;border-top:2px"}}><b>{{ $estimate->language->name }}</b></td>
                            <td rowspan="5">PC</td>
                            <td style="font-size: 8pt;{{$estimate->t?'background-color:grey;':''}}">T</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                        </tr>
                        {{-- v1 --}}
                        <tr>
                            <td style="font-size: 8pt;{{$estimate->v1?'background-color:#f5f5f5;':''}}">V</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                        </tr>
                        {{-- v2 --}}
                        <tr>
                            <td style="font-size: 8pt;{{$estimate->v2?'background-color:#f5f5f5;':''}}">V2</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                        </tr>
                        {{-- bt --}}
                        <tr>
                            <td style="font-size: 8pt;{{$estimate->bt?'background-color:grey;':''}}">BT</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                        </tr>
                        {{-- btv --}}
                        <tr>
                            <td style="font-size: 8pt;{{$estimate->btv?'background-color:#f5f5f5;':''}}">BTV</td>
                            
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt">

                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt">
                            </td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                            <td style="font-size: 8pt"></td>
                        </tr>
                        @php $pageBreakIndex+=5;@endphp
                        @if($index < $estimates->count()-1)
                            @if($pageBreakIndex % 30 == 0 && $pageBreakIndex == 30 )
                                    </tbody>
                                </table>
                                @if($index < $estimate->count())
                                    <div class="page-break"></div>
                                    <table class="job-details">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Langs.</th>
                                                <th>Unit</th>
                                                <th>Writer Code</th>
                                                <th>Employee Code</th>
                                                <th>PD</th>
                                                <th>CR</th>
                                                <th>C/NC</th>
                                                <th>DV</th>
                                                <th>F/QC</th>
                                                <th>Sent Date</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                @endif 
                            @elseif($pageBreakIndex % 75 == 0 && $pageBreakIndex == 75  )
                                    </tbody>
                                </table>
                                <br>
                                <div class="page-break"></div>
                                <table class="job-details">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Langs.</th>
                                            <th>Unit</th>
                                            <th>Writer Code</th>
                                            <th>Employee Code</th>
                                            <th>PD</th>
                                            <th>CR</th>
                                            <th>C/NC</th>
                                            <th>DV</th>
                                            <th>F/QC</th>
                                            <th>Sent Date</th>
                                        </tr>
                                    </thead>
                                <tbody>

                            @elseif($pageBreakIndex % 75 == 0 && $pageBreakIndex > 75 )
                                    </tbody>
                                </table>
                                <div class="page-break"></div>
                                <table class="job-details">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Langs.</th>
                                            <th>Unit</th>
                                            <th>Writer Code</th>
                                            <th>Employee Code</th>
                                            <th>PD</th>
                                            <th>CR</th>
                                            <th>C/NC</th>
                                            <th>DV</th>
                                            <th>F/QC</th>
                                            <th>Sent Date</th>
                                        </tr>
                                    </thead>
                                <tbody>
                            @endif
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
        <br>
        <table class="additional-info" >
            <tr>
                <td>Delivery Date</td>
                <td style="border-left-style: hidden;">
                    <strong>{{ $job->date ? \Carbon\Carbon::parse($job->date)->format('j M Y') : '' }}</strong>
                </td>
                <td>Bill No</td>
                <td style="border-left-style: hidden;font-weight: bold;">{{ $job->bill_no ?? '' }}</td>
            </tr>
            <tr>
                <td>Words / Units</td>
                <td style="border-left-style: hidden;font-weight: bold;">{{$job->wu_text??"As per proforma"}}</td>
                <td>Bill Date</td>
                <td style="border-left-style: hidden;font-weight: bold;">
                    {{ $job->bill_date&&$job->bill_date!='0000-00-00' ? \Carbon\Carbon::parse($job->bill_date)->format('j M Y') : '' }}</td>
            </tr>
            <tr>
                <td>Old Job No</td>
                <td style="border-left-style: hidden;font-weight: bold;font-size:20px;">{{ $job->old_job_no ?? '' }}</td>
                <td>Bill sent on</td>
                <td style="border-left-style: hidden;font-weight: bold;">
                    {{ $job->sent_date&&$job->sent_date!='0000-00-00' ? \Carbon\Carbon::parse($job->sent_date)->format('j M Y') : '' }}</td>
            </tr>
            <tr>
                <!-- <td>Checked with Operator</td>
                <td style="border-left-style: hidden;font-weight: bold;">{{ $job->operator ?? '' }}</td> -->
                <td style="vertical-align: top;">Remark</td>
                <td style="border-left-style: hidden;font-weight: bold;width: 30%">{{ $job->remark ?? '' }}</td>
                <td style="vertical-align: top;">Informed To</td>
                <td style="border-left-style: hidden;font-weight: bold;font-size:15px;vertical-align: top;">{{ $job->client_person->name ?? '' }}</td>
            </tr>
            <!-- <tr>
                <td>Remark</td>
                <td style="border-left-style: hidden;font-weight: bold;">{{ $job->remark ?? '' }}</td>
                <td style="border-left-style: hidden;"></td>
                <td style="border-left-style: hidden;"></td>
            </tr> -->

           
        </table>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Kesen Language Bureau. All rights reserved.</p>
        </div>
    </div>
</body>

</html>