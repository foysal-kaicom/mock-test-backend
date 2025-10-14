<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #1d4ed8;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #1d4ed8;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }

        .info-box {
            background-color: #f1f5f9;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .info-box strong {
            display: inline-block;
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ url('logo/logo.png') }}" alt="Mock Test Logo" style="max-height: 60px;">
        </div>

        <h2>Welcome, {{ $candidate->full_name }}!</h2>

        <p>We’re excited to have you on board. Your account has been successfully created. Below are your login credentials:</p>

        <div class="info-box">
            <p><strong>Email:</strong> {{ $candidate->email }}</p>
            <p><strong>Password:</strong> {{ $plainPassword }}</p>
        </div>

        <p>To access your account, click the button below:</p>

        <a href="{{config('app.frontend.url')}}/sign_in" class="button" style="color:white !important">Login to Your Account</a>

        <p>If you didn’t request this account or believe this was a mistake, please contact our support team.</p>

        <div class="footer">
            &copy; {{ date('Y') }} kaicomsolutions. All rights reserved.
        </div>
    </div>
</body>

</html>