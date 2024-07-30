<!DOCTYPE html>
<html>
<head>
    <title>Job Completed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }
        .content ul {
            list-style-type: none;
            padding: 0;
        }
        .content ul li {
            background-color: #e9f7ef;
            margin: 10px 0;
            padding: 10px;
            border-left: 5px solid #28a745;
        }
        .content ul li span {
            font-weight: bold;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px 20px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Email for billing</h1>
        </div>
        <div class="content">
            <p>“Dear Accounts Team, </p>
            <br>
            <p>
                {{$jobDetails->handle_by->name ?? ''}} has completed the {{$jobDetails->estimate_document_id}} of {{$jobDetails->estimate?$jobDetails->estimate->client->name:$jobDetails->no_estimate->client->name}} having job no {{$jobDetails->sr_no}} {{$jobDetails->estimate?? 'and quotation no: '.$jobDetails->estimate->estimate_no}}
            </p>
            <br>
            <p>
            The job is now ready for billing.
            </p>
            <br>
            <p>Thank you</p>
            <br>
            <p>Project Management Team</p>
        </div>
    </div>
</body>
</html>
