<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailContact extends Model
{
    protected $fillable = [
        'email',
        'token',
        'subscribed_at',
        'ip_address',
        'source',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->subscribed_at)) {
                $model->subscribed_at = now();
            }
        });
    }
}
