<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Auth;

class NewsletterHtmlController extends Controller
{
    public function show($id)
    {
        $newsletter = Newsletter::findOrFail($id);

        if (!Auth::user()
            ->followedVCs()
            ->where('vcs.id', $newsletter->vc_id)
            ->exists()) {
            abort(403, 'You are not authorized to view this newsletter.');
        }

        return response($newsletter->body_html)
            ->header('Content-Type', 'text/html')
            ->header('X-Frame-Options', 'SAMEORIGIN');
    }
}
