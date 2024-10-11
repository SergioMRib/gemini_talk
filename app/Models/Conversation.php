<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [ 'message', 'user_id', 'is_ai'];

    protected function casts(): array
    {
        return [
            'is_ai' => 'boolean',
        ];
    }


    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);

    }
}
