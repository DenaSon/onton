<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ByblosRadar | {{ $newsletter->subject ?? 'N/A' }}</title>
</head>
<body>
{!! $newsletter->body_html ?? nl2br(e($newsletter->body_plain)) !!}

<hr style="margin-top: 30px; margin-bottom: 10px; border: none; border-top: 1px solid #ccc;">

<p style="font-size: 12px; color: #666;">
    Best regards,<br>
    <strong>ByblosRadar Team</strong><br>
    <a href="https://byblosradar.com" style="color: #1a73e8; text-decoration: none;">byblosradar.com</a>
</p>
</body>
</html>
