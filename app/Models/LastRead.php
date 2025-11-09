<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastRead extends Model
{
    protected $fillable = [
        'user_id',
        'conversation_id',
        'last_read_message_id'
    ];
}
