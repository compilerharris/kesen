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
        }

        .container {
            width: 100%;
            margin: 20px auto;
            box-sizing: border-box;
        }

        .header,
        .footer {
            text-align: center;
            padding: 10px 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .job-details,
        .client-info,
        .additional-info {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .job-details td,
        .job-details th,
        .client-info td,
        .client-info th,
        .additional-info td,
        .additional-info th {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            word-wrap: break-word;
        }

        .job-details th,
        .client-info th,
        .additional-info th {
            background-color: #f2f2f2;
        }

        .client-info td,
        .job-info td,
        .additional-info td {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if ($job->estimate->client->client_metric->code == 'KCP')
                <img src="{{ public_path('img/kesen-communication.jpeg') }}" alt="Iceberg Image" width="100%">
            @elseif ($job->estimate->client->client_metric->code == 'KLB')
                <img src="{{ public_path('img/kesen-language-buea.jpeg') }}" alt="Iceberg Image" width="100%">
            @elseif ($job->estimate->client->client_metric->code == 'LGS')
                <img src="{{ public_path('img/kesen-linguist-Servi-llp.jpeg') }}" alt="Iceberg Image" width="100%">
            @else
                <img src="{{ public_path('img/kesen-linguist-system.jpeg') }}" alt="Iceberg Image" width="100%">
            @endif
            <h2>JOB CARD</h2>
        </div>
        <table class="client-info">
            <tr>
                <th>Client</th>
                <td>{{ $job->client->name ?? '' }}</td>
                <th>Job No.</th>
                <td>{{ $job->sr_no ?? '' }}</td>
            </tr>
            <tr>
                <th>Headline</th>
                <td>{{ $job->description ?? '' }}</td>
                <th>Date</th>
                <td>{{$job->date? \Carbon\Carbon::parse($job->date)->format('j M Y') : '' }}</td>
            </tr>
            <tr>
                <th>Protocol No.</th>
                <td>{{ $job->protocol_no ?? '' }}</td>
                <th>Client Contact Person Name</th>
                <td>{{ $job->client_person->name ?? '' }}</td>
            </tr>
            <tr>

                <th>Estimate No.</th>
                <td>{{ $job->estimate->estimate_no ?? '' }}</td>
                
                <th>Client Contact Person Number</th>
                <td>{{ $job->client_person->phone_no ?? '' }}</td>
            </tr>

            <tr>
                <th></th>
                <td></td>
                <th>Handled By</th>
                <td>{{ $job->handle_by->name ?? '' }}</td>
            </tr>
        </table>
        <table class="job-details">
            <thead>
                <tr>
                    <th colspan="3" style="font-size: 8pt">Langs.</th>
                    <th style="font-size: 8pt">Unit</th>
                    <th style="font-size: 8pt">Writer Code</th>
                    <th style="font-size: 8pt">Verified By</th>
                    <th style="font-size: 8pt">Two Way QC Verified By</th>
                    <th style="font-size: 8pt">PD</th>
                    <th style="font-size: 8pt">CR</th>
                    <th style="font-size: 8pt">C/NC</th>
                    <th style="font-size: 8pt">DV</th>
                    <th style="font-size: 8pt">F/QC</th>
                    <th style="font-size: 8pt">Sent Date</th>
                </tr>
            </thead>
            <tbody>
                @php $estimate_details_list=[];@endphp
                @php $temp_index=1;@endphp
                @if(count($job->jobCard)!=0)
                    @foreach ($job->jobCard as $card)
                        <tr>
                            @if (!in_array($card->estimate_detail_id, $estimate_details_list))
                                @php $temp_index=1;@endphp
                                @php $estimate_details_list[] = $card->estimate_detail_id; @endphp
                                <td rowspan={{ $job->jobCard->where('sync_no', $card->sync_no)->count() * 2 }}
                                    style="font-size: 8pt">{{ $card->estimateDetail->language->name }}</td>
                            @else
                                    @php $temp_index+=1;@endphp
                            @endif
                        
                            <td rowspan="2" style="font-size: 8pt">PC {{ $temp_index}}</td>


                            <td style="font-size: 8pt">T</td>
                            <td style="font-size: 8pt">{{ $card->t_unit }}</td>
                            <td style="font-size: 8pt">
                                {{ Modules\WriterManagement\App\Models\Writer::where('id', $card->t_writer_code)->first()->code }}
                            </td>
                            <td style="font-size: 8pt">{{ App\Models\User::where('id', $card->t_emp_code)->first()->code }}
                            </td>
                            <td style="font-size: 8pt">
                                {{ App\Models\User::where('id', $card->t_two_way_emp_code)->first()->code }}</td>
                            <td style="font-size: 8pt">
                                {{ $card->t_pd ? \Carbon\Carbon::parse($card->t_pd)->format('j M Y') : '' }}</td>
                            <td style="font-size: 8pt">
                                {{ $card->t_cr ? \Carbon\Carbon::parse($card->t_cr)->format('j M Y') : '' }}</td>
                            <td style="font-size: 8pt">{{ $card->t_cnc }}</td>
                            <td style="font-size: 8pt">{{ $card->t_dv }}</td>
                            <td style="font-size: 8pt">{{ $card->t_fqc }}</td>
                            <td style="font-size: 8pt">
                                {{ $card->t_sentdate ? \Carbon\Carbon::parse($card->t_sentdate)->format('j M Y') : '' }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt">BT</td>
                            <td style="font-size: 8pt">{{ $card->t_unit }}</td>
                            <td style="font-size: 8pt">
                                {{ Modules\WriterManagement\App\Models\Writer::where('id', $card->bt_writer_code)->first()->code??'' }}
                            </td>
                            <td style="font-size: 8pt">{{ App\Models\User::where('id', $card->bt_emp_code)->first()->code??'' }}
                            </td>
                            <td style="font-size: 8pt">
                                {{ App\Models\User::where('id', $card->bt_two_way_emp_code)->first()->code??'' }}</td>
                            <td style="font-size: 8pt">
                                {{ $card->bt_pd ? \Carbon\Carbon::parse($card->bt_pd)->format('j M Y') : '' }}</td>
                            <td style="font-size: 8pt">
                                {{ $card->bt_cr ? \Carbon\Carbon::parse($card->bt_cr)->format('j M Y') : '' }}</td>
                            <td style="font-size: 8pt">{{ $card->bt_cnc }}</td>
                            <td style="font-size: 8pt">{{ $card->bt_dv }}</td>
                            <td style="font-size: 8pt">{{ $card->bt_fqc }}</td>
                            <td style="font-size: 8pt">
                                {{ $card->bt_sentdate ? \Carbon\Carbon::parse($card->bt_sentdate)->format('j M Y') : '' }}</td>
                        </tr>
                    @endforeach
                @else
                @foreach (\Modules\EstimateManagement\App\Models\EstimatesDetails::where('estimate_id', $job->estimate_id)->get() as $card)
                 
                <tr>
                    @if (!in_array($card->id, $estimate_details_list))
                        @php $estimate_details_list[] = $card->id; @endphp
                        <td rowspan="2"
                            style="font-size: 8pt">{{ $card->language->name }}</td>
                    @endif


                    <td style="font-size: 8pt">T</td>
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
                    <td style="font-size: 8pt">
                        </td>
                </tr>
                <tr>
                    <td style="font-size: 8pt">BT</td>
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
                    <td style="font-size: 8pt">
                       </td>
                </tr>
            @endforeach
                @endif


            </tbody>
        </table>
        <table class="additional-info">
            <tr>
                <td>Delivery Date</td>
                <td style="border-left-style: hidden;">
                    <strong>{{ $job->delivery_date ? \Carbon\Carbon::parse($job->delivery_date)->format('j M Y') : '' }}</strong>
                </td>
                <td>Bill No</td>
                <td style="border-left-style: hidden;">{{ $job->bill_no ?? '' }}</td>
            </tr>
            <tr>
                <td>Words / Units</td>
                <td style="border-left-style: hidden;">As per proforma</td>
                <td>Bill Date</td>
                <td style="border-left-style: hidden;">
                    {{ $job->bill_date ? \Carbon\Carbon::parse($job->bill_date)->format('j M Y') : '' }}</td>
            </tr>
            <tr>
                <td>Old Job No</td>
                <td style="border-left-style: hidden;">{{ $job->old_job_no ?? '' }}</td>
                <td>Bill sent on</td>
                <td style="border-left-style: hidden;">
                    {{ $job->sent_date ? \Carbon\Carbon::parse($job->sent_date)->format('j M Y') : '' }}</td>
            </tr>
            <tr>
                <td>Checked with Operator</td>
                <td style="border-left-style: hidden;"></td>
                <td>Informed To</td>
                <td style="border-left-style: hidden;">{{ $job->client_person->name ?? '' }}</td>
            </tr>

            <tr>
                <td>Remarks: Quot No. </td>
                <td style="border-left-style: hidden;">
                    {{ \Modules\EstimateManagement\App\Models\Estimates::whereIn('id', explode(',', $job->other_details))->get()->pluck('estimate_no')->implode(', ') ?? '' }}
                </td>
                <td></td>
                <td style="border-left-style: hidden;"></td>
            </tr>
        </table>
    </div>
</body>

</html>
