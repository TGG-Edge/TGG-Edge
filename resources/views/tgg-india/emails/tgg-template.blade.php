<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? 'TGG India Notification' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            background-color: #f6f9fc;
            padding: 30px 0;
        }

        .email-box {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .header {
            background: #004aad;
            color: #fff;
            text-align: center;
            padding: 25px;
        }

        .header img {
            width: 120px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .body {
            padding: 30px;
            line-height: 1.7;
            font-size: 14px;
        }

        .body h2 {
            color: #004aad;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .body p {
            margin: 10px 0;
        }

        .button {
            display: inline-block;
            margin: 25px 0;
            padding: 10px 25px;
            background: #004aad;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .button:hover {
            background: #003380;
        }

        .footer {
            background: #f1f4f8;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }

        .footer a {
            color: #004aad;
            text-decoration: none;
            font-weight: 500;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="email-box">

            <div class="header">
                <img src="https://tggindia.com/wp-content/uploads/2020/09/cropped-logo_png_final-1024x281.png" alt="TGG India Logo">
                <h1>{{ $subject ?? 'TGG Meta - TGG India' }}</h1>
            </div>

            <div class="body">
                <h2>Hello {{ $name ?? 'User' }},</h2>
                <p>{!! $message ?? 'This is a system-generated message from TGG India.' !!}</p>

                @if(!empty($data['button_text']) && !empty($data['button_url']))
                    <p style="text-align:center;">
                        <a href="{{ $data['button_url'] }}" class="button">{{ $data['button_text'] }}</a>
                    </p>
                @endif

                <p>Best regards,<br><strong>TGG India Team</strong></p>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} TGG India. All rights reserved.</p>
                <p><a href="https://tggindia.com">Visit our website</a></p>
            </div>

        </div>
    </div>

</body>
</html>
