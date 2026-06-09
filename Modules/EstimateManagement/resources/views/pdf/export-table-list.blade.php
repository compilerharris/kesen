<!DOCTYPE html>
<html lang="en">
@php
    $heads = [
        [
            'label' => 'ID',
        ],
        [
            'label' => 'Date',
        ],
        [
            'label' => 'Estimate No',
        ],
        [
            'label' => 'Amount',
        ],

        [
            'label' => 'Metrix',
        ],
        [
            'label' => 'Client Name',
        ],
        [
            'label' => 'Contact Person Name',
        ],
        [
            'label' => 'Contact Person Number',
        ],
        

        // [
        //     'label' => 'Headline',
        // ],
       
        // [
        //     'label' => 'Currency',
        // ],

        [
            'label' => 'Protocol No',
        ],
        [
            'label' => 'Created By',
        ],
        [
            'label' => 'Status',
        ],
        // [
        //     'label' => 'Created By',
        // ],
        // [
        //     'label' => 'Action',
        // ],
        
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
    <title>Document</title>
</head>
<body >
&nbsp;&nbsp;<span class="badge badge-primary" >Total Estimate: {{ $total_count }}</span>
<span class="badge badge-success">Total Approved: {{ $estimates_approved_count }}</span>
<span class="badge badge-danger">Total Rejected: {{ $estimates_rejected_count }}</span>

<table style=" margin-top:20px">
    <thead>
        <tr>
            @foreach ($heads as $head)
                <th>{{ $head['label'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
        <tr>
            <td>{{ $row->sr }}</td>
            <td>{{ $row->date }}</td>
            <td>{{ $row->estimate_no }}</td>
            <td>{{ $row->amount }}</td>
            <td>{{ $row->metrix }}</td>
            <td>{{ $row->client_name }}</td>
            <td>{{ $row->contact_name }}</td>
            <td>{{ $row->contact_phone }}</td>
            <td>{{ $row->protocol_no }}</td>
            <td>{{ $row->created_by }}</td>
            <td class="{{ $row->status_code == 0 ? 'status-pending' : ($row->status_code == 1 ? 'status-approved' : 'status-rejected') }}">
                {{ $row->status }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
