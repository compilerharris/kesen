<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writer Work Done</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
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
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1 style="color: green;border-bottom: 3px solid green;width: 150px;display: inline-block;">KeSen</h1>
        
        <p>KANAKIA WALL STREET, A WING, 904-905, 9TH FLOOR, ANDHERI KURLA ROAD, CHAKALA , ANDHERI EAST, MUMBAI - 400 093</p>
        <p>Phone: 002 4034 8888, 4034 8844 to 8865 | Fax: 22674618</p>
        <h2>WRITER WORK DONE</h2>
        <p>Period: {{\Carbon\Carbon::parse($min)->format('d M, Y')}} - {{\Carbon\Carbon::parse($max)->format('d M, Y')}}</p>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $total=0; @endphp
                @foreach ($writer_report as $index=>$writer)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$writer->writer->writer_name}}</td>
                        <td>{{$writer->writer->code}}</td>
                        <td>{{$writer->payment_total_amounts??0}}</td>
                        @php $total+=$writer->payment_total_amounts??0; @endphp
                    </tr>
                 
                @endforeach
                <tr>
                    <td colspan="3" style="font-weight: bold">Total</td>
                    <td style="font-weight: bold">{{$total}}</td>
                </tr>
               
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
