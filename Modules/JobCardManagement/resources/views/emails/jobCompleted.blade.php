<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOB COMPLETION LETTER & FEEDBACK FORM</title>
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
                <h2>JOB COMPLETION LETTER & FEEDBACK FORM</h2>
                <p style="float:right">Date: {{date('d-M-Y')}}</p><br>
                <p>To:</p>
                <p>{{$jobDetails->estimate->client_person->name ?? ''}}<br>
                    {{$jobDetails->estimate->client->name ?? ''}}<br>
                    Job No: <b>{{$jobDetails->sr_no ?? ''}}</b></p>
                <p>Dear Sir/Madam,</p>
            </div>
            <div class="email">
                <p>We confirm that Job No: <b>{{$jobDetails->sr_no ?? ''}}</b> is completed and delivered to you.</p>
                <p>Kindly send us a confirmation that the job is complete and satisfactory from your end. If we do not receive a confirmation from you in the next 2 working days, we will presume that the job is accepted.</p>
                <p>You are requested to kindly complete the <b>attached Feedback Form</b> to help us serve you better.</p>
                <p>Thanking You in advance for your early reply. <br>
                    Looking forward to working with you again soon.</p>
                <p>Warm Regards<br><b>KeSen Group of Companies</b></p>
            </div>
        </div>
    </div>
    <div class="footer">
    </div>
</body>
</html>
