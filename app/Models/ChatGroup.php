<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
    ];

    /**
     * Get the user that chatGroup belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
