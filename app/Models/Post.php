<?php

namespace App\Models;

use App\Models\Concerns\HasChronology;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasChronology;
    use HasFactory;
    use HasSlug;

    protected $guarded = [];

    protected $casts = [
        'author_id' => 'int',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getUrlAttribute(): string
    {
        return "/posts/{$this->slug}";
    }

    public function getImageUrlAttribute(): string
    {
        if (preg_match('`^https?://`', $this->image)) {
            return $this->image;
        }

        return '/' . $this->image;
    }

    public function author(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): Relation
    {
        return $this->hasMany(Comment::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
