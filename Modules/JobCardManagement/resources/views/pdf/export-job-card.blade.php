<!DOCTYPE html>
<html lang="en">
@php
    $heads = [
        ['label' => '#'],
        ['label' => 'Job No'],
        ['label' => 'Date'],
        ['label' => 'Protocol No'],
        ['label' => 'Client Name'],
        ['label' => 'Document Name'],
        ['label' => 'Handled By'],
        ['label' => 'Billing Status'],
        ['label' => 'Bill Date'],
        ['label' => 'Informed To'],
        ['label' => 'Sent Date'],
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
            font-size: 8pt;
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
    </style>
    <title>Job Card</title>
</head>
<body >
&nbsp;&nbsp;<span class="badge badge-primary" >Total Job Card: {{ $jobCard->count() }}</span>
<span class="badge badge-success">Total Completed: {{ $jobCard->complete_count }}</span>
<span class="badge badge-danger">Total Canceled: {{ $jobCard->cancel_count }}</span>

<table style=" margin-top:20px">
    <thead>
        <tr>
            @foreach ($heads as $head)
                <th>{{ $head['label'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($jobCard as $index=>$row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->sr_no }}</td>
            <td>{{ $row->date?\Carbon\Carbon::parse($row->date)->format('j M Y'):'' }}</td>
            <td>{{ $row->protocol_no }}</td>
            <td>{{ $row->estimate->client->name }}</td>
            <td>{{ $row->estimate_document_id }}</td>
            <td>{{ $row->handle_by->name }}</td>
            <td>{{ $row->bill_no!=null || $row->bill_no!='' ? "billed-".$row->bill_no:"unbilled" }}</td>
            <td>{{ $row->bill_date? \Carbon\Carbon::parse($row->bill_date)->format('j M Y'):'' }}</td>
            <td>{{ $row->estimate->client_person->name??'' }}</td>
            <td>{{ $row->sent_date?\Carbon\Carbon::parse($row->sent_date)->format('j M Y'):'' }}</td>
            <td  class="{{ $row->status == 0 ? 'status-pending' : ($row->status == 1 ? 'status-approved' : 'status-rejected') }}">
                {{ $row->status == 0 ? 'In Progress' : ($row->status == 1 ? 'Completed' : 'Canceled') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
