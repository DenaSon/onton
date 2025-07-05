<?php

namespace App\Models;

use App\Models\VC;
use App\Models\Newsletter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Cache;

/**
 * Class Tag
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $type
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|VC[] $vcs
 * @property-read \Illuminate\Database\Eloquent\Collection|Newsletter[] $newsletters
 */
class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'type',
    ];

    /**
     * The VCs that belong to this tag (polymorphic many-to-many).
     *
     * @return MorphToMany<VC>
     */
    public function vcs(): MorphToMany
    {
        return $this->morphedByMany(VC::class, 'taggable');
    }

    /**
     * The Newsletters that belong to this tag (polymorphic many-to-many).
     *
     * @return MorphToMany<Newsletter>
     */
    public function newsletters(): MorphToMany
    {
        return $this->morphedByMany(Newsletter::class, 'taggable');
    }




    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('tags.vertical');
            Cache::forget('tags.stage');
        });

        static::deleted(function () {
            Cache::forget('tags.vertical');
            Cache::forget('tags.stage');
        });
    }



}
