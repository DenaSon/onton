<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ByblosRadar | {{ $newsletter->subject ?? 'N/A'}}</title>
</head>
<body>
{!! $newsletter->body_html ?? nl2br(e($newsletter->body_plain)) !!}
</body>
</html>
