<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password - Safari Tours</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: linear-gradient(135deg, #1e3a5f 0%, #2d5a7b 100%); padding: 30px; text-align: center; color: white;">
            <h1 style="margin: 0; font-size: 28px;">🦁 Safari Tours</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Reset Your Password</p>
        </div>

        <div style="background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 20px;">
            <p style="margin: 0 0 15px 0; font-size: 16px;">Hello {{ $user->name }},</p>
            
            <p style="margin: 0 0 15px 0; font-size: 16px;">
                We received a request to reset your password for your Safari Tours account. 
                Click the button below to create a new password:
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $resetUrl }}" style="background: #e67e22; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                    Reset My Password
                </a>
            </div>

            <p style="margin: 0 0 15px 0; font-size: 16px;">
                This link will expire in 1 hour. If you didn't request this password reset, 
                please ignore this email.
            </p>

            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 20px;">
                <p style="margin: 0 0 5px 0; font-size: 14px; font-weight: bold;">Trouble clicking the button?</p>
                <p style="margin: 0 0 5px 0; font-size: 14px;">Copy and paste this link into your browser:</p>
                <p style="margin: 0; font-size: 12px; word-break: break-all; color: #666;">
                    {{ $resetUrl }}
                </p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px; color: #666; font-size: 12px;">
            <p style="margin: 0 0 10px 0;">&copy; {{ date('Y') }} Safari Tours. All rights reserved.</p>
            <p style="margin: 0;">This email was sent to {{ $user->email }}</p>
        </div>
    </div>
</body>
</html>