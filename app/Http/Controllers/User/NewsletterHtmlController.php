<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class NewsletterHtmlController extends Controller
{
    use AuthorizesRequests;

    public function show($id)
    {
        $newsletter = Newsletter::findOrFail($id);

        $this->authorize('viewHtml', $newsletter);

        return response($newsletter->body_html)
            ->header('Content-Type', 'text/html')
            ->header('X-Frame-Options', 'SAMEORIGIN')
            ->header('Content-Security-Policy', "default-src 'self'; style-src 'self' 'unsafe-inline'; script-src 'none';")
            ->header('X-Content-Type-Options', 'nosniff');
    }
}
