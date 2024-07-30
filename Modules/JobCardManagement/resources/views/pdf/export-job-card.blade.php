<!DOCTYPE html>
<html lang="en">
@php
    $heads = [
        ['label' => '#'],
        ['label' => 'Date'],
        ['label' => 'Job No.'],
        ['label' => 'Project Manager'],
        ['label' => 'Client'],
        ['label' => 'Client Contact'],
        ['label' => 'Estimate No.'],
        ['label' => 'Document Name'],
        ['label' => 'Protocol No.'],
        ['label' => 'Version No.'],
        ['label' => 'Version Date'],
        ['label' => 'Laguages'],
        ['label' => 'Delivery Date'],
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
            <!-- @foreach ($heads as $head)
                <th>{{ $head['label'] }}</th>
            @endforeach -->
            <th style="width:2%">#</th>
            <th style="width:6%">Date</th>
            <th style="width:6%">Job No.</th>
            <th style="width:8%">Project Manager</th>
            <th style="width:8%">Client</th>
            <th style="width:8%">Client Contact</th>
            <th style="width:8%">Estimate No.</th>
            <th style="width:9%">Document Name</th>
            <th style="width:8%">Protocol No.</th>
            <th style="width:5%">Version No.</th>
            <th style="width:8%">Version Date</th>
            <th style="width:15%">Laguages</th>
            <th style="width:8%">Delivery Date</th>
            <th style="width:10%">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jobCard as $index=>$row)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $row->created_at?\Carbon\Carbon::parse($row->created_at)->format('j M Y'):'' }}</td>
            <td>{{ $row->sr_no }}</td>
            <td>{{ $row->handle_by->name }}</td>
            <td>{{ $row->estimate?$row->estimate->client->name:$row->no_estimate->client->name }}</td>
            <td>{{ $row->estimate?$row->estimate->client_person->name:$row->no_estimate->client_person->name }}</td>
            <td>{{ $row->estimate?$row->estimate->estimate_no:'No Estimate' }}</td>
            <td>{{ $row->estimate_document_id }}</td>
            <td>{{ $row->protocol_no }}</td>
            <td>{{ $row->version_no }}</td>
            <td>{{ $row->version_date }}</td>
            <td>{{ $row->languages }}</td>
            <td>{{ $row->date?\Carbon\Carbon::parse($row->date)->format('j M Y'):'' }}</td>
            <td  class="{{ $row->status == 0 ? 'status-pending' : ($row->status == 1 ? 'status-approved' : 'status-rejected') }}">
                {{ $row->status == 0 ? 'In Progress' : ($row->status == 1 ? 'Completed' : 'Canceled') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
