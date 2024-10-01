<!DOCTYPE html>
<html lang="en">
@php
    $heads = [
        ['label' => '#'],
        ['label' => 'Date'],
        ['label' => 'Job No'],
        ['label' => 'Project Manager'],
        ['label' => 'Client Name'],
        ['label' => 'Contact Person'],
        ['label' => 'Estimate No.'],
        ['label' => 'Languages'],
        ['label' => 'Old Job No.'],
        ['label' => 'Protocol No.'],
        ['label' => 'Job Type'],
        ['label' => 'Job Description'],
        ['label' => 'Remark'],
        ['label' => 'Billing Status'],
        ['label' => 'Status']
    ];

@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            word-break: break-word;
            table-layout: fixed;
            font-size: 12pt;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .badge {
            padding: 10px;
            border-radius: 4px;
            color: white;
            margin-right: 10px;
        }
        .badge-primary {
            background-color: #007bff;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .status-pending {
            background-color: white;
        }
        .status-approved {
            background-color: #28a745;
        }
        .status-rejected {
            background-color: #dc3545;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            text-decoration: none;
            color: black;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .status-warning {
            background-color: #ffc107;
        }
        .status-danger {
            background-color: #dc3545;
        }
        .status-success {
            background-color: #28a745;
        }
    </style>
    <title>Job Card</title>
</head>
<body>
    @use('\Carbon\Carbon','Carbon')
    &nbsp;<span class="badge badge-primary" style="font-size: 2rem" >Total Job Card: {{ $jobCard->count() }}</span>
    <span class="badge badge-success" style="font-size: 2rem">Total Completed: {{ $jobCard->complete_count }}</span>
    <span class="badge badge-danger" style="font-size: 2rem">Total Canceled: {{ $jobCard->cancel_count }}</span>
    <table style=" margin-top:20px">
        <thead>
            <tr>
                {{-- @foreach ($heads as $head)
                    <th>{{ $head['label'] }}</th>
                @endforeach --}}
                <th>#</th>
                <th>Date</th>
                <th>Job No</th>
                <th>Client Name</th>
                <th>Job Description</th>
                <th>P.M.</th>
                <th>Delivery Date</th>
                <th>Billing Status</th>
                <th>Status</th>
                {{-- <th>Contact Person</th>
                <th>Estimate No.</th>
                <th>Languages</th>
                <th>Old Job No.</th>
                <th>Protocol No.</th>
                <th>Job Type</th>
                <th>Remark</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($jobCard as $index=>$row)
            <tr>
                <td style="font-size: 1.2rem;"><b>{{ $loop->index+1 }}</b></td>
                <td style="font-size: 1.2rem;"><b>{{ $row->created_at?Carbon::parse($row->created_at)->format('j M Y'):'' }}</b></td>
                <td style="font-size: 1.2rem;"><b>{{ $row->sr_no }}</b></td>
                <td style="font-size: 1.2rem;"><b>{{ $row->estimate?$row->estimate->client->name:$row->no_estimate->client->name }}</b></td>
                <td style="font-size: 1.2rem;"><b>{{ $row->estimate_document_id }}</b></td>
                <td style="font-size: 1.2rem;"><b>{{ $row->handle_by->code??'' }}</b></td>
                <td style="font-size: 1.2rem;"><b>{{ $row->date?Carbon::parse($row->date)->format('j M Y'):'' }}</b></td>
                <td style="font-size: 1.2rem;" class="{{empty($row->bill_no)&&$row->status==1?'status-warning':(isset($row->bill_no)&&$row->status==1&&$row->payment_status=='Unpaid'?'status-danger':(isset($row->bill_no)&&$row->status==1&&$row->payment_status=='Paid'?'status-success':''))}}"><b>{{$row->status==2?'---':(empty($row->bill_no)&&$row->status==1?'Unbilled':($row->bill_no??'---'))}}</b></td>
                <td style="font-size: 1.2rem;" class="{{ $row->status == 0 ? '' : ($row->status == 1 ? 'status-success' : 'status-danger') }}"><b>{{ $row->status ==  0 ? (count($row->jobCard)>0?'In Progress':'---') : ($row->status == 1 ? 'Completed' : 'Canceled') }}</b></td>
                {{-- <td>{{ $row['clientContact'] }}</td>
                <td>{{ $row['estimateNo'] }}</td>
                <td>{{ $row['languages'] }}</td>
                <td>{{ $row['oldJobNo'] }}</td>
                <td>{{ $row['protocolNo'] }}</td>
                <td>{{ $row['jobType'] }}</td>
                <td>{{ $row['remark'] }}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
