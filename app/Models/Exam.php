<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "therapy_id",
        'questions',
    ];

    /**
     * Get the user that owns the exam.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function therapy(): BelongsTo
    {
        return $this->belongsTo(Therapy::class)->withTrashed();
    }

}
