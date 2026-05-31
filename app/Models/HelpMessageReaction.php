<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpMessageReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'help_message_id',
        'user_id',
        'user_type',
        'emoji',
    ];

    /**
     * Get the message this reaction belongs to
     */
    public function message()
    {
        return $this->belongsTo(HelpMessage::class, 'help_message_id');
    }

    /**
     * Get the user who reacted
     */
    public function user()
    {
        return $this->morphTo(__FUNCTION__, 'user_type', 'user_id');
    }
}