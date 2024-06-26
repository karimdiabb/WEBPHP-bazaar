<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function advertenties()
    {
        return $this->hasMany(Advertisement::class, 'user_id');
    }

    public function purchasedAdvertisements()
    {
        return $this->belongsToMany(Advertisement::class, 'sale_history', 'user_id', 'advertisement_id')->withTimestamps();
    }

    public function rentedAdvertisements()
    {
        return $this->hasMany(Advertisement::class, 'renter_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Advertisement::class, 'favorite_advertisements')->withTimestamps();
    }

    public function writtenProductReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function highlightedAds()
    {
        return $this->belongsToMany(Advertisement::class, 'highlighted_ads', 'user_id', 'advertisement_id')->withTimestamps();
    }

    public function hasRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->role->name == $role) {
                    return true;
                }
            }
        } else {
            return $this->role->name == $roles;
        }

        return false;
    }


}
