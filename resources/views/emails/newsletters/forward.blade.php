<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Byblos | {{ $newsletter->subject ?? 'N/A' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333; padding: 30px; line-height: 1.6;">

<table width="100%" cellpadding="0" cellspacing="0" style="max-width: 700px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden;">
    <tr>
        <td style="padding: 24px 24px 8px 24px;">
            {{-- VC Name --}}
            @if($newsletter->vc?->name)
                <p style="margin: 0 0 4px 0; font-size: 13px; color: #6b7280;">
                    From: <strong>{{ $newsletter->vc->name }}</strong>
                </p>
            @endif

            {{-- Subject --}}
            <h2 style="margin: 0; font-size: 20px; color: #1a202c;">
                {{ $newsletter->subject ?? 'Untitled Newsletter' }}
            </h2>
        </td>
    </tr>

    <tr>
        <td style="padding: 0 24px 24px 24px;">
            {!! $newsletter->body_html ?? nl2br(e($newsletter->body_plain)) !!}
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 24px; border-top: 1px solid #e2e8f0; font-size: 13px; color: #6b7280; text-align: center;">
            <p style="margin: 0 0 6px;">
                Thanks for staying connected with us.
            </p>
            <strong style="display: block; margin-bottom: 4px;"> The Byblos Team </strong>
            <a href="https://byblos.com"
               style="color: #3b82f6; text-decoration: none; font-weight: 500;">
                byblos.com
            </a>
        </td>
    </tr>
</table>

</body>
</html>
