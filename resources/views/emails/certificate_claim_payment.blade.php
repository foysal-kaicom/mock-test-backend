<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            background-color: #2740e1;
            color: #ffffff;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
            font-size: 16px;
            color: #333333;
        }

        .email-body p {
            margin: 10px 0;
        }

        .email-footer {
            text-align: center;
            background-color: #f4f4f4;
            padding: 10px;
            font-size: 14px;
            color: #777777;
            border-radius: 0 0 8px 8px;
        }

        .button {
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
            <h1>{{ $data['title'] }}</h1>
        </div>

        <!-- Email Body -->
        <div class="email-body">
            <p>Dear {{ $candidateName }},</p>
            <p>We are happy to inform you that your payment for the JPT certificate claim has been approved.</p>
            <div style="font-size: 13px">
                <p>Thank you for your patience throughout the process.</p>

                <p>If you have any further questions, feel free to Contact Us</a>.</p>
            </div>

        </div>

        <!-- Email Footer -->
        <div class="email-footer">
            <p>Best regards,</p>
            <p>The JPTBD Team</p>
        </div>
    </div>
</body>

</html>
