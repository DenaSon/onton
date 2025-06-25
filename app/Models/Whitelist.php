<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Whitelist extends Model
{
    protected $guarded = [];
    public function vc(): BelongsTo
    {
        return $this->belongsTo(Vc::class);
    }
}
