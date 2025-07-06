<?php
// app/Models/VC.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;

class Vc extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'country',
        'website',
        'substack_url',
        'medium_url',
        'blog_url',
        'official_x_accounts',
        'staff_x_accounts',
        'logo_url',
    ];

    protected $casts = [
        'official_x_accounts' => 'array',
        'staff_x_accounts' => 'array',
    ];


    /*
    |--------------------------------------------------------------------------
    | Polymorphic Tags Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get all tags associated with this VC.
     *
     * @return MorphToMany<Tag>
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get all tags of type 'stage' associated with this VC.
     *
     * @return MorphToMany<Tag>
     */
    public function stages(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->where('type', 'stage');
    }

    /**
     * Get all tags of type 'vertical' associated with this VC.
     *
     * @return MorphToMany<Tag>
     */
    public function verticals(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->where('type', 'vertical');
    }

    /*
    |--------------------------------------------------------------------------
    | Newsletters Relation
    |--------------------------------------------------------------------------
    */

    /**
     * Get all newsletters published by this VC.
     *
     * @return HasMany<Newsletter>
     */
    public function newsletters(): HasMany
    {
        return $this->hasMany(Newsletter::class);
    }

    public function latestNewsletter()
    {
        return $this->hasOne(Newsletter::class)->latestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | Whitelists Relation
    |--------------------------------------------------------------------------
    */

    /**
     * Get all whitelist entries related to this VC.
     *
     * @return HasMany<Whitelist>
     */
    public function whitelists(): HasMany
    {
        return $this->hasMany(Whitelist::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Self-referencing: Portfolio Investments Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the VCs that this VC has invested in (its portfolio).
     *
     * @return BelongsToMany<Vc>
     */
    public function investedIn(): BelongsToMany
    {
        return $this->belongsToMany(Vc::class, 'vc_investments', 'investor_id', 'portfolio_id');
    }

    /**
     * Get the VCs that have invested in this VC (its investors).
     *
     * @return BelongsToMany<Vc>
     */
    public function investors(): BelongsToMany
    {
        return $this->belongsToMany(Vc::class, 'vc_investments', 'portfolio_id', 'investor_id');
    }


    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_vc_follows')
            ->withTimestamps();
    }

    public function scopeWithVerticals($query, $verticalIds)
    {
        return $query->whereHas('tags', fn($q) =>
        $q->where('type', 'vertical')->whereIn('tags.id', $verticalIds)
        );
    }

    public function scopeWithStages($query, $stageIds)
    {
        return $query->whereHas('tags', fn($q) =>
        $q->where('type', 'stage')->whereIn('tags.id', $stageIds)
        );
    }




    protected static function booted()
    {
        static::deleting(function (Vc $vc) {

            if ($vc->logo_url) {
                Storage::disk('public')->delete($vc->logo_url);
            }

            $vc->newsletters()->delete();
            $vc->whitelists()->delete();

            $vc->investedIn()->detach();
            $vc->investors()->detach();
            $vc->tags()->detach();
        });
    }


}
