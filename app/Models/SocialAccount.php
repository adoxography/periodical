<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_name',
        'provider_id'
    ];

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
