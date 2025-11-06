<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'completed',
        'user_id',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
