<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectToUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'user_id'
    ];

    /**
     * Get the project  that the task belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the user that the timesheet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
