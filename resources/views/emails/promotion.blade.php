
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ e($promotion->title) }}</title>

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
            margin-top: 0;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #1d4ed8;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
        .content p { line-height: 1.6; }
    </style>
</head>
<body>
<div class="container">
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="{{ $message->embed(public_path('logo/logo.png')) }}" alt="{{ config('app.name') }} Logo" style="max-height: 60px;width:200px">
    </div>

    @php
        $candidateName = $candidate?->full_name ?? ($candidate?->first_name ?? 'Candidate');
        $subject    = $promotion->subject ?? 'Special Promotion';
    @endphp

    <h2>Hello, {{ e($candidateName) }}!</h2>

    <div class="content">
        <p>{!! $promotion->body !!}</p>

        <p style="margin-top:16px;">
            Best regards,<br>
            {{ e(config('app.name')) }}
        </p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} {{ e(config('app.name')) }}. All rights reserved.
    </div>
</div>
</body>
</html>
