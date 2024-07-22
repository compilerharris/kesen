<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Confirmation Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 0 10px;
        }
        .header {
            background-color: #108f45;
            color: white;
            margin: 0 auto;
            padding: 0 10px;
            display: block;
            width: 80%;
            height: 50px;
        }
        .content {
            padding: 20px;
            /* border: 1px solid #108f45; */
            margin-top: 20px;
        }
        .content h2 {
            text-align: center;
            background-color: #E8F5E9;
            padding: 10px;
            margin-left:  0 0 0 -20px;
            padding-left: 20px;
        }
        .content p {
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            background-color: #108f45;
            color: white;
            padding: 10px;
            margin: 0 auto;
            width: 80%;
            height: 30px;
        }
        .left-line{
            border-left: 2px solid #108f45;
            margin-left: -20px;
            padding-left: 20px;
        }
        .email{
            border-left: 2px solid white;
            margin-left: -20px;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="float:left;" style="width: 70%">
            <p>Call Us: <a style="text-decoration: none;color: white;" href="tel:2240348888">+91 22 40348888</a></p>
        </div>
        <div style="float:right;" >
            <p>Mail Us: <a style="text-decoration: none;color: white;" href="mailto:kesen@kesen.in">kesen@kesen.in</a></p>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <center><img src="{{$message->embed(public_path('img/logo.png'))}}" alt="Kesen Logo" width="30%" style="display:block"></center>
            <div class="left-line">
                <h2>JOB CONFIRMATION LETTER</h2>
                <p style="float:right">Date: {{date('d-M-Y')}}</p><br>
                <p>To:</p>
                <p>{{$jobRegister->estimate->client_person->name ?? ''}}<br>
                    {{$jobRegister->estimate->client->name ?? ''}}<br>
                    Document Name: <b>{{$jobRegister->estimateDetail->document_name ?? ''}}</b><br>
                    Estimate No:  <b>{{$jobRegister->estimate->estimate_no ?? ''}}</b><br>
                    Job No: <b>{{$jobRegister->sr_no ?? ''}}</b></p>
                <p>Dear Sir/Madam,</p>
            </div>
            <div class="email">
              <p>Thank You for giving us an opportunity to serve you!</p>
              <p>We have initiated your document having <strong>Job No. {{$jobRegister->sr_no}}</strong> for <strong>{{ implode(', ',array_unique($jobRegister->languages)) }}</strong>.</p>
              <p>This document will be completed by <strong>{{\Carbon\Carbon::parse($jobRegister->date)->format('j M Y')}}</strong>.</p>
              <p>Please Quote our <strong>Job No. {{$jobRegister->sr_no}}</strong> for all our future correspondence/ corrections / amendments suggestions related to this Job.</p>
              <p>In case of any queries please feel free to mail at <a href="mailto:kesen@kesen.in" style="text-decoration:none;">kesen@kesen.in</a> or call us on: <strong><a href="tel:2240348888" style="text-decoration:none;color:black;">+91-22-4034 8888</a></strong>  or <strong>Mr. Keith Myers</strong> on <strong><a  href="tel:98210 22327" style="text-decoration: none;color:black;">+91  98210 22327</a></strong>.</p>
              <p>Assuring you of our best services at all times.</p>
              <p>Warm Regards<br><b>KeSen Group of Companies</b></p>
            </div>
        </div>
    </div>
    <div class="footer">
    </div>
</body>
</html>