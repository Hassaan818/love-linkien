<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px;">
        <h2 style="color: #333;">Forgot Your Password?</h2>

        <p>Hello,</p>

        <p>You requested to reset your password. Use the OTP below to proceed:</p>

        <h1 style="text-align: center; letter-spacing: 5px; color: #2d3748;">
            {{ $otp }}
        </h1>

        <p>This OTP will expire in <strong>10 minutes</strong>.</p>

        <p>If you did not request a password reset, please ignore this email.</p>

        <br>

        <p>Thanks,<br>
            <strong>{{ config('app.name') }}</strong>
        </p>
    </div>
</body>

</html>