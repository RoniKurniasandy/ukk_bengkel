<!DOCTYPE html>
<html>
<head>
    <title>Kode Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #0d6efd; text-align: center;">Reset Password</h2>
        <p>Halo,</p>
        <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
        <p>Gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #0d6efd; background-color: #f8f9fa; padding: 15px 30px; border-radius: 5px; border: 1px dashed #0d6efd;">
                {{ $token }}
            </span>
        </div>

        <p>Kode ini akan kadaluarsa dalam 60 menit.</p>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777; text-align: center;">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>
</html>
