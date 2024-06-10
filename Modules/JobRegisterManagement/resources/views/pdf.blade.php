<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesen Language Bureau Job Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            border: 1px solid black;
            padding: 20px;
            max-width: 900px;
            margin: 0 auto;
        }
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: green;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            font-size: 18px;
            margin-top:10px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .job-register {
            font-size: 18px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            table-layout: fixed;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        .header-table th, .header-table td {
            text-align: left;
            font-size: 7pt;
            word-break: break-word;
            table-layout: fixed;
        }
        .header-table td{
            
            word-break: break-word;
            
        }
        .language-table th, .language-table td {
            text-align: center;
            font-size: 7pt;
            word-break: break-word;
        }
    </style>
</head>
<body>
    <div class="container">
        @if ($jobRegister->estimate->client->client_metric->code == 'KCP')
            <img src="{{ public_path('img/kesen-communication.jpeg') }}" alt="Iceberg Image" width="100%">
        @elseif ($jobRegister->estimate->client->client_metric->code == 'KLB')
            <img src="{{ public_path('img/kesen-language-buea.jpeg') }}" alt="Iceberg Image" width="100%">
        @elseif ($jobRegister->estimate->client->client_metric->code == 'LGS')
            <img src="{{ public_path('img/kesen-linguist-Servi-llp.jpeg') }}" alt="Iceberg Image" width="100%">
        @else
            <img src="{{ public_path('img/kesen-linguist-system.jpeg') }}" alt="Iceberg Image" width="100%">
        @endif
        
        <div class="subtitle">JOB REGISTER <span class="job-register">{{$jobRegister->sr_no}}</span></div>
        
        <table class="header-table">
            <tr>
                <th>Client Name</th>
                <th>Client Contact Person Name</th>
                <th>Contact No</th>
                <th>Estimate No.</th>
                <th>Po No.</th>
                <th>Headline</th>
                <th>Protocol No.</th>
                <th>Handled By</th>
                <th>Admin</th>
                <th>Accountant</th>
                <th>Date</th>
                <th>Other Details</th>
            </tr>
            <tr>
                <td>{{$jobRegister->client->name}}</td>
                <td>{{$jobRegister->estimate->client_person->name}}</td>
                <td>{{$jobRegister->client->phone_no}}</td>
                <td>{{$jobRegister->estimate->estimate_no}}</td>
                <td>{{$jobRegister->po_number}}</td>
                <td>{{$jobRegister->description}}</td>
                <td>{{$jobRegister->protocol_no}}</td>
                <td>{{$jobRegister->handle_by->name}}</td>
                <td>{{\App\Models\User::whereHas('roles', function($q){$q->where('name', 'Admin');})->first()->name}}</td>
                <td>{{$jobRegister->accountant->name}}</td>
                <td>{{$jobRegister->date?\Carbon\Carbon::parse($jobRegister->date)->format('j M Y'):''}}</td>
                <td>{{\Modules\EstimateManagement\App\Models\Estimates::whereIn('id',explode(',', $jobRegister->estimate_id))->get('estimate_no')->pluck('estimate_no')->implode(', ')}}</td>
            </tr>
        </table>
        
        <table class="language-table">
            

            <tr>
                <th colspan="3">Langs.</th>
                <th>Unit</th>
                <th>Writer Code</th>
            </tr>
            @php $estimate_details_list=[];@endphp
            @php $temp_index=1;@endphp
            @foreach ($jobRegister->jobCard as $index=>$card)
                
                <tr>
                    @if(!in_array($card->estimate_detail_id, $estimate_details_list))
                        @php $temp_index=1;@endphp
                        @php $estimate_details_list[] = $card->estimate_detail_id; @endphp
                        <td rowspan={{$jobRegister->jobCard->where('sync_no',$card->sync_no)->count()*2}} style="font-size: 8pt">{{$card->estimateDetail->language->name}}</td>
                    @else
                        @php $temp_index+=1;@endphp
                    @endif
            
                    <td rowspan="2">PC {{ $temp_index}}</td>
                    <td >T</td>
                    <td>{{$card->t_unit}}</td>
                    <td>{{Modules\WriterManagement\App\Models\Writer::where('id',$card->t_writer_code)->first()->code}}</td>
                </tr>
                <tr>
                    
                    <td>BT</td>
                    
                    <td>{{$card->bt_unit}}</td>
                    <td></td>
                </tr>
            @endforeach
            
        </table>
    </div>
</body>
</html>
