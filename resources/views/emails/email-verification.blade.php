<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #2d5a27 0%, #3d7a37 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .content h2 {
            color: #2d5a27;
            margin-top: 0;
        }
        .button {
            display: inline-block;
            background-color: #2d5a27;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #1d4a1f;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .logo-placeholder {
            font-size: 40px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-placeholder">🦁</div>
            <h1>Safari Tours</h1>
        </div>
        <div class="content">
            <h2>Welcome to Safari Tours!</h2>
            <p>Dear {{ $user->name }},</p>
            <p>Thank you for registering with Safari Tours! We're excited to have you on board.</p>
            <p>To complete your registration and verify your email address, please use the following verification code:</p>
            <p style="text-align: center; background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
                <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #2d5a27;">{{ $verificationCode }}</span>
            </p>
            <p><strong>Important:</strong> This code will expire in 15 minutes. Enter it on the verification page to complete your registration.</p>
            <p>If you didn't create an account with Safari Tours, please ignore this email.</p>
            <p>Best regards,<br>The Safari Tours Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Safari Tours. All rights reserved.</p>
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>