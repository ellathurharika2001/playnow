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
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 40px 30px;
        }
        .otp-box {
            background: #f8f9fa;
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .otp-label {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }
        .info-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .social-links {
            margin-top: 15px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 5px;
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Email Verification</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2 style="color: #333; margin-top: 0;">Hello, {{ $user->name }}! 👋</h2>
            
            <p>Thank you for registering with {{ config('app.name') }}. To complete your registration and verify your email address, please use the verification code below:</p>

            <!-- OTP Box -->
            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-label">Your Verification Code</div>
            </div>

            <p style="text-align: center; margin: 20px 0;">
                Enter this code on the verification page to activate your account.
            </p>

            <!-- Info Box -->
            <div class="info-box">
                <p><strong>⏰ Important:</strong> This code will expire in <strong>10 minutes</strong> for security reasons.</p>
            </div>

            <p style="font-size: 14px; color: #666;">
                If you didn't create an account with {{ config('app.name') }}, please ignore this email or contact our support team if you have concerns.
            </p>

            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">

            <p style="font-size: 14px; color: #666; margin-bottom: 5px;">
                <strong>Need help?</strong> Contact our support team at 
                <a href="mailto:support@{{ config('app.url') }}" style="color: #667eea; text-decoration: none;">support@{{ config('app.url') }}</a>
            </p>

            <p style="font-size: 14px; color: #666; margin-top: 0;">
                Best regards,<br>
                <strong>The {{ config('app.name') }} Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0 0 10px 0;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p style="margin: 0;">
                This is an automated email. Please do not reply to this message.
            </p>
            
            <!-- Social Links (Optional) -->
            <!--
            <div class="social-links">
                <a href="#">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">Instagram</a>
            </div>
            -->
        </div>
    </div>
</body>
</html>