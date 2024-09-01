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
            <h2>{{Modules\WriterManagement\App\Models\Writer::where('id',$writerWorkload->writerId)->first()->writer_name}} Workload</h2>
        </div>
        <table class="payment-table">
            <thead>
                <tr>
                    <th style="text-align: left;">Job No.</th>
                    <th style="text-align: left">Project Manager</th>
                    <th style="text-align: left">Document Name</th>
                    <th style="text-align: left">Lang-uage</th>
                    <th style="text-align: left">Trans-lation Unit</th>
                    <th style="text-align: left">Job Given On</th>
                    <th style="text-align: left">Back Translation Unit</th>
                    <th style="text-align: left">Job Given On</th>
                </tr>
            </thead>
            <tbody>
                @if(count($writerWorkload)>0)
                    @foreach ($writerWorkload as $job)
                        @php
                            $estimateDetail = Modules\EstimateManagement\App\Models\EstimatesDetails::where('id',$job->estimate_detail_id)->first();
                            $jobRegister = Modules\JobRegisterManagement\App\Models\JobRegister::where('sr_no',$job->job_no)->first();
                        @endphp
                        <tr>
                            <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 50px;">{{$job->job_no}}</p></td>
                            <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 70px;">{{$jobRegister?App\Models\User::where('id',$jobRegister->handled_by_id)->first('name')->name:''}}</p></td>
                            <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 90px;">{{$estimateDetail?$estimateDetail->document_name:''}}</p></td>
                            <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 40px;">{{$estimateDetail?Modules\LanguageManagement\App\Models\Language::where('id',$estimateDetail->lang)->first('name')->name:''}}</p></td>
                            @if($job->t_writer_code == $writerWorkload->writerId)
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">{{$job->t_unit}}</p></td>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 60px;">{{$job->t_pd?Carbon\Carbon::parse($job->t_pd)->format('j M Y'):''}}</p></td>
                            @else
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;"></p></td>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 60px;"></p></td>
                            @endif
                            @if($job->bt_writer_code == $writerWorkload->writerId)
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 30px;">{{$job->bt_unit?$job->bt_unit:''}}</p></td>
                                <td style="text-align: left;"><p style="word-wrap: break-word; text-wrap: wrap; width: 60px;">{{$job->bt_pd?Carbon\Carbon::parse($job->bt_pd)->format('j M Y'):''}}</p></td>
                            @else
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
    </div>
</body>
</html>
