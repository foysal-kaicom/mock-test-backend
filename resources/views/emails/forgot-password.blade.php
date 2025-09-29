<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
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
    </style>
</head>

<body>
    <div class="container">
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ url('logo/logo.png') }}" alt="JPT Logo" style="max-height: 60px;">
        </div>

        <h2>Hello, {{ $candidate_name }}!</h2>

        <p>We received a request to reset your password. Click the button below to proceed. This link will expire in <strong>3 minutes</strong>.</p>

        <p style="text-align: center;">
            <a href="{{ $resetLink }}" class="button">Reset Your Password</a>
        </p>

        <p>If you didn’t request this password reset, you can safely ignore this email.</p>
        <p>Thank You.</p>

        <div class="footer">
            &copy; {{ date('Y') }} kaicomsolutions. All rights reserved.
        </div>
    </div>
</body>

</html>
