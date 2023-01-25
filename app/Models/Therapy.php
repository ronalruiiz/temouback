<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Therapy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'expiration',
        'description',
        'type',
        'visibility'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiration' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($therapy) {
            $therapy->link = Str::slug($therapy->name.Str::random(40), '-');
            $therapy->save();
        });
    }

}
