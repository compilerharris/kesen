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
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header div {
            display: flex;
            flex-direction: column;
        }
        .content {
            padding: 20px;
            border: 1px solid #4CAF50;
            margin-top: 20px;
        }
        .content h1 {
            text-align: center;
            background-color: #E8F5E9;
            padding: 10px;
            border-bottom: 2px solid #4CAF50;
        }
        .content p {
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="left">
                <p>Call Us: 98210 22327</p>
            </div>
            <div class="right">
                <p>Mail Us: klanguagebureau@gmail.com</p>
            </div>
        </div>
        <div class="content">
            <h1>FINALIZED JOB CONFIRMATION LETTER</h1>
            <p style="float:right">Date: 06 June 2024</p><br>
            <p>{{$job->estimate->client_person->name ?? ''}}<br>>
                Protocol No.: {{$job->protocol_no ?? ''}}<br>
                Job Code: {{$job->sr_no ?? ''  ?? ''}}</p>
            <p>Dear {{$job->estimate->client_person->name ?? ''}},</p>
            <p>With reference to the above document, kindly send us a mail, confirming that the task undertaken is complete and satisfactory.</p>
            <p><strong>Thanking You in advance for your early reply.</strong></p>
            <p>If we do not receive a communication from you within 7 working days, we will presume that the job is accepted.</p>
            <p>Kindly complete the feedback form to help us, to serve you better.</p>
            <p>Looking forward to work with you in the near future.</p>
            <p>Warm Regards<br>Keith Myers</p>
        </div>
        <div class="footer">
            <p>©2024-25 Kesen. All rights reserved.<br>
        </div>
    </div>
</body>
</html>
