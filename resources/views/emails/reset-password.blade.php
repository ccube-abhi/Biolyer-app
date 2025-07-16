<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Hello {{ $user->name ?? 'User' }},</h2>

    <p>We received a request to reset your password. Click the button below to reset it:</p>

    <p style="text-align: center;">
        <a href="{{ $url }}"
           style="background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
            Reset Password
        </a>
    </p>

    <p>This password reset link will expire in 60 minutes.</p>

    <p>If you didn’t request a password reset, no further action is required.</p>

    <p>Thanks,<br>The {{ config('app.name') }} Team</p>
</body>
</html>
