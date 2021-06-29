<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatWords extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'word',
    ];
    
    /**
     * Get the user that the sender belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id','id');
    }

    /**
     * Get the user that the sender belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id','id');
    }
}
