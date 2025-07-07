<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        {{ $newsletter->subject ? config('app.name') . ' | ' . $newsletter->subject : config('app.name') . ' Newsletter' }}
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light only">

</head>
<body style="font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f9f9f9; color: #333; padding: 30px; line-height: 1.6;">

<table width="100%" cellpadding="0" cellspacing="0" style="max-width: 700px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; overflow: hidden;">
    <tr>
        <td style="padding: 24px 24px 8px 24px;">
            {{-- VC Name --}}
            @if($newsletter->vc?->name)
                <p style="margin: 0 0 2px 0; font-size: 13px; color: #6b7280;">
                    From: <strong>{{ $newsletter?->vc?->name }}</strong>
                </p>
                <p style="margin: 0 0 4px 0; font-size: 12px; color: #9ca3af;">
                    Forwarded to you by <strong>{{ config('app.name') }}</strong>
                </p>
            @endif

            {{-- Subject --}}
            <h2 style="margin: 0; font-size: 20px; color: #1a202c;">
                {{ $newsletter?->subject ?? 'Untitled Newsletter' }}
            </h2>
        </td>
    </tr>

    <tr>
        <td style="padding: 0 24px 24px 24px;">
            {!! trim($newsletter?->body_html) ?? nl2br(e($newsletter?->body_plain)) !!}
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 24px; border-top: 1px solid #e2e8f0; font-size: 13px; color: #6b7280; text-align: center;">
            <p style="margin: 0 0 8px;">
                You're receiving this newsletter via <strong>{{ config('app.name') }}</strong>.
                To explore more updates and newsletters tailored to your interests,
                visit your personalized feed:
            </p>

            <a href="{{ route('panel.feed.index') }}"
               style="display: inline-block; margin-top: 8px; padding: 8px 16px; background-color: #3b82f6; color: white; text-decoration: none; font-weight: 500; border-radius: 4px;">
                Go to My Feed
            </a>

            <p style="margin-top: 16px; font-size: 12px; color: #9ca3af;">
                Powered by {{ config('app.name') }} &mdash; {{ config('app.url') }}
            </p>
        </td>

    </tr>
</table>

</body>
</html>
