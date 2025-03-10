<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AskGeminiLog extends Model
{
    protected $fillable = ['log_entry', 'from_human'];
}
