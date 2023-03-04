<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Therapy extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'expiration',
        'description',
        'type',
        'questions',
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

    /**
     * Get the exams for the blog post.
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

}
