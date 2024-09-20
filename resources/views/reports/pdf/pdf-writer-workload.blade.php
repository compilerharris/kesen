<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writer Workload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: green;
            margin: 0;
        }
        .header p {
            margin: 0;
        }
        .info-table, .payment-table {
            width: 100%;
            border-collapse: collapse;
            
        }
        .info-table td, .payment-table th, .payment-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .info-table td:nth-child(2), .payment-table th, .payment-table td {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
        }
        .amount-words {
            font-weight: bold;
            margin-top: 20px;
            text-align: left;
        }
        td{
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <center><img src="{{public_path('img/logo.png')}}" alt="Kesen Logo" width="30%" style="display:block"></center>
            <p>KANAKIA WALL STREET, A WING, 904-905, 9TH FLOOR, ANDHERI KURLA ROAD, CHAKALA, ANDHERI EAST, MUMBAI - 400 093</p>
            <p>022 4034 8888 / 022 4034 8801 / 022 4034 8845</p>
            <p>PAN NO: AADFL1698N GST NO: 27AADFL1698N1ZP</p>
            @if($writerWorkload->writerId)
                <h2>{{Modules\WriterManagement\App\Models\Writer::where('id',$writerWorkload->writerId)->first()->writer_name}} Workload</h2>
            @else
                <h2>{{$writerWorkload->language}} Workload</h2>
            @endif
        </div>
        @if($writerWorkload->writerId)
            <table class="payment-table">
                <thead>
                    <tr>
                        <th style="text-align: left;">Job No.</th>
                        <th style="text-align: left">Project Manager</th>
                        <th style="text-align: left">Document Name</th>
                        <th style="text-align: left">Language</th>
                        <th style="text-align: left">Trans-lation Unit</th>
                        <th style="text-align: left">Job Given On</th>
                        <th style="text-align: left">Back Trans-lation Unit</th>
                        <th style="text-align: left">Job Given On</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($writerWorkload)>0)
                        @foreach ($writerWorkload as $job)
                            <tr>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 50px;">{{$job->jobRegister->sr_no}}</p></td>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 40px;">{{$job->jobRegister->handle_by->code??''}}</p></td>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 300px;">{{$job->jobRegister->estimate_document_id??''}}</p></td>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 100px;">{{$job->estimateDetail->language->name??'---'}}</p></td>
                                @if(in_array($job->t_writer_code,$writerWorkload->writerIds))
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">{{$job->t_unit}}</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 100px;">{{$job->t_pd?Carbon\Carbon::parse($job->t_pd)->format('j M Y'):''}}</p></td>
                                @else
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;"></p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 100px;"></p></td>
                                @endif
                                @if(in_array($job->bt_writer_code,$writerWorkload->writerIds))
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">{{$job->bt_unit?$job->bt_unit:''}}</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 100px;">{{$job->bt_pd?Carbon\Carbon::parse($job->bt_pd)->format('j M Y'):''}}</p></td>
                                @else
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">---</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 100px;">---</p></td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="text-align:center;">No Data Found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @else
            <table class="payment-table">
                <thead>
                    <tr>
                        <th style="text-align: left;">Job No.</th>
                        <th style="text-align: left">Project Manager</th>
                        <th style="text-align: left">Document Name</th>
                        <th style="text-align: left">Writer</th>
                        <th style="text-align: left">Trans-lation Unit</th>
                        <th style="text-align: left">Job Given On</th>
                        <th style="text-align: left">BT Writer</th>
                        <th style="text-align: left">Back Trans-lation Unit</th>
                        <th style="text-align: left">Job Given On</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($writerWorkload)>0)
                        @foreach ($writerWorkload as $job)
                            <tr>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 50px;">{{$job->jobRegister->sr_no}}</p></td>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 40px;">{{$job->jobRegister->handle_by->code??''}}</p></td>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 300px;">{{$job->jobRegister->estimate_document_id??''}}</p></td>
                                @if(in_array($job->t_writer_code,$writerWorkload->writerIds))
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 40px;">{{$job->tWriter->code??'---'}}</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">{{$job->t_unit}}</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 100px;">{{$job->t_pd?Carbon\Carbon::parse($job->t_pd)->format('j M Y'):''}}</p></td>
                                @else
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 40px;">---</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">---</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 100px;">---</p></td>
                                @endif
                                @if(in_array($job->bt_writer_code,$writerWorkload->writerIds))
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 40px;">{{$job->btWriter->code??'---'}}</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">{{$job->bt_unit?$job->bt_unit:'---'}}</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 100px;">{{$job->bt_pd?Carbon\Carbon::parse($job->bt_pd)->format('j M Y'):'---'}}</p></td>
                                @else
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 40px;">---</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">---</p></td>
                                    <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 60px;">---</p></td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="text-align:center;">No Data Found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
