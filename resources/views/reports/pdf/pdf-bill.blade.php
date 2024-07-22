<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            width: 95%;
            margin: 20px auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: green;
            border-bottom: 3px solid green;
            display: inline-block;
            padding-bottom: 5px;
        }
        .header p {
            margin: 5px 0;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px; /* Reduced font size */
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px; /* Reduced padding */
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tfoot {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>KeSen</h1>
        <p>KANAKIA WALL STREET, A WING, 904-905, 9TH FLOOR, ANDHERI KURLA ROAD, CHAKALA , ANDHERI EAST, MUMBAI - 400 093</p>
        <p>Phone: 002 4034 8888, 4034 8844 to 8865 | Fax: 22674618</p>
        <h2>Bill Details</h2>
        <p>Period: {{ \Carbon\Carbon::parse($min)->format('d M, Y') }} - {{ \Carbon\Carbon::parse($max)->format('d M, Y') }}</p>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Date</th>
                    <th>Job Number</th>
                    <th>Client Name</th>
                    <th>Client Person</th>
                    <th>Accountant</th>
                    <th>Handled by</th>
                    <th>Billed Status</th>
                    <th>Bill Amount</th>
                    <th>Paid Amount</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $total_amount = 0; 
                    $total_paid = 0; 
                @endphp
                @foreach ($bill_data as $index => $bill)
                    @php
                        $total_amount += $bill->bill_amount??0;
                        $total_paid += $bill->paid_amount??0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($bill->date)->format('j M Y') }}</td>
                        <td>{{ $bill->sr_no }}</td>
                        <td>{{ $bill->client->name }}</td>
                        <td>{{ $bill->client_person->name }}</td>
                        <td>{{ $bill->accountant->name }}</td>
                        <td>{{ $bill->handle_by->name }}</td>
                        <td>{{ $bill->payment_status == 'Paid' ? 'Paid' : ($bill->payment_status == 'Partial' ? 'Partial' : 'Unpaid') }}</td>
                        <td>{{ $bill->bill_amount??0 }}</td>
                        <td>{{ $bill->paid_amount??0 }}</td>
                    </tr>
                @endforeach
                @php
                    $balance_amount = $total_amount - $total_paid;
                @endphp
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">Total</td>
                    <td>{{ $total_amount }}</td>
                    <td>{{ $total_paid }}</td>
                </tr>
                <tr>
                    <td colspan="9">Balance Amount</td>
                    <td>{{ $balance_amount }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

</body>
</html>
