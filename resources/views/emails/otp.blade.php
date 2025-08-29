<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .otp-box {
            background-color: #e9ecef;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 5px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Password Reset Request</h2>
    </div>

    <p>Hello,</p>

    <p>You have requested to reset your password. Please use the following OTP code to proceed:</p>

    <div class="otp-box">
        {{ $otp }}
    </div>

    <p><strong>Important:</strong></p>
    <ul>
        <li>This OTP code will expire in 10 minutes</li>
        <li>Do not share this code with anyone</li>
        <li>If you didn't request this, please ignore this email</li>
    </ul>

    <p>If you have any questions, please contact our support team.</p>

    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
    </div>
</body>
</html>
