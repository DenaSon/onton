<?php

namespace App\Models;

use App\Models\Cashier\Subscription;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property bool $is_suspended
 * @property \DateTime|null $email_verified_at
 * @property string|null $remember_token
 *
 * @property-read Collection|Subscription[] $subscriptions
 * @property-read Subscription|null $activeSubscription
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_suspended',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes casts.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the initials of the user's name.
     *
     * @return string Initials composed of first letters of each part of the name.
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Get the first name part of the user's full name.
     *
     * @return string First name extracted from the full name.
     */
    public function firstName(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->first();
    }

    /**
     * Get all subscriptions associated with the user.
     *
     * @return HasMany<Subscription>
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the active subscription for the user, if any.
     *
     * @return HasOne<Subscription>|null
     */
    public function activeSubscription(): ?HasOne
    {
        return $this->hasOne(Subscription::class)
            ->where('stripe_status', 'active');
    }

    /**
     * Check if the user account is suspended.
     *
     * @return bool True if suspended, false otherwise.
     */
    public function isSuspended(): bool
    {
        return (bool) $this->getAttribute('is_suspended');
    }

    public function followedVCs()
    {
        return $this->belongsToMany(Vc::class, 'user_vc_follows')
            ->withTimestamps();
    }

    public function isFollowingVC($vcId)
    {
        return $this->followedVCs()->where('vc_id', $vcId)->exists();
    }


    public function notificationSetting()
    {
        return $this->hasOne(UserNotificationSetting::class);
    }

    public function sentNewsletters()
    {
        return $this->belongsToMany(Newsletter::class, 'newsletter_user_sends')
            ->withPivot('sent_at')
            ->withTimestamps();
    }

    protected static function booted()
    {
        static::created(function (User $user) {
            $user->notificationSetting()->create([
                'frequency' => 'daily',
                'last_sent_at' => null,
            ]);
        });
    }




}
