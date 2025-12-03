<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'farm_name',
        'bio',
        'location',
        'specialization',
        'phone',
        'email',
        'profile_image',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
