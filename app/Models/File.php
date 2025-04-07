<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'summary',
        'url'
    ];

    protected $casts = [
        'is_processed' => 'boolean',
    ];
}
