<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{


    protected $fillable = [
        'vc_id',
        'name',
        'website',
        'country',
        'founded_at',
        'description',
        'logo_url',
    ];

    public function vc()
    {
        return $this->belongsTo(VC::class);
    }
}
