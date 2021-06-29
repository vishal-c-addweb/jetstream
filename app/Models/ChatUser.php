<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'time',
    ];
    
    protected $dates = ['time'];

    /**
     * Get the user that the chat belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function getTime8601Attribute()
    {
        return $this->time->format('c');
    }
    
}
