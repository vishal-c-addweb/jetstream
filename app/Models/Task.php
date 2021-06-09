<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'project_id',
        'created_by'
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
        return $this->belongsTo(User::class,'created_by','id');
    }
}