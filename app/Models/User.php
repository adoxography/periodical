<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use HasSlug;
    use Notifiable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUrlAttribute(): string
    {
        return "/users/{$this->slug}";
    }

    public function getAvatarUrlAttribute(): string
    {
        if (!$this->avatar) {
            return '';
        }

        if (preg_match('`^https?://`', $this->avatar)) {
            return $this->avatar;
        }

        return "/{$this->avatar}";
    }

    public function posts(): Relation
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function accounts(): Relation
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
