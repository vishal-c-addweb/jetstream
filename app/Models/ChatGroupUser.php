<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroupUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
    ];

    /**
     * Get the user that the chatgroup belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
