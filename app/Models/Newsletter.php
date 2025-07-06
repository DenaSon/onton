<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Newsletter extends Model
{
    protected $fillable = [
        'vc_id', 'subject', 'from_email', 'to_email',
        'body_plain', 'body_html', 'sent_at', 'received_at',
        'message_id', 'hash', 'processing_status', 'is_forwarded', 'forwarded_at'
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sent_at' => 'datetime',
        'forwarded_at' => 'datetime',
    ];


    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }


    public function categories(): MorphToMany
    {
        return $this->tags()->where('type', 'category');
    }

    public function industries(): MorphToMany
    {
        return $this->tags()->where('type', 'industry');
    }

    public function vc()
    {
        return $this->belongsTo(Vc::class);
    }


    public function sentToUsers()
    {
        return $this->belongsToMany(User::class, 'newsletter_user_sends')
            ->withPivot('sent_at')
            ->withTimestamps();
    }

    public function getBodyPreview(int $limit = 250): string
    {
        $text = $this->body_plain ?? '';


        $text = strip_tags($text);


        $paragraphs = collect(preg_split('/\r\n|\r|\n/', $text))
            ->map(fn($p) => trim($p))
            ->filter(function ($p) {

                return $p !== ''
                    && !preg_match('/^\[image.*\]$/i', $p)
                    && !preg_match('/^https?:\/\/\S+$/i', $p)
                    && strlen(strip_tags($p)) > 10;
            });


        $body = $paragraphs->first() ?? '';

        return \Str::limit($body, $limit);
    }



}
