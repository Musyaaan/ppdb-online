<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px;">

    <div style="max-width: 480px; margin: auto; background: white; border-radius: 10px; padding: 30px;">

        <h2 style="color: #333;">Reset Password PPDB SDN Legok 3</h2>

        <p style="color: #555;">
            Gunakan kode OTP berikut untuk mereset password kamu:
        </p>

        <div style="
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 10px;
            text-align: center;
            color: #4F46E5;
            background: #EEF2FF;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        ">
            {{ $otp }}
        </div>

        <p style="color: #888; font-size: 13px;">
            Kode ini berlaku selama <strong>5 menit</strong>. 
            Jangan bagikan kode ini ke siapapun.
        </p>

    </div>

</body>
</html>