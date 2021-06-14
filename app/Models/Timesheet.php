<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'task_id',
        'timesheet_date',
        'hour',
        'minute',
        'description'
    ];

    /**
     * Get the user that the timesheet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    /**
     * Get the project  that the timesheet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    /**
     * Get the task that the timesheet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function task()
    {
        return $this->belongsTo(Task::class,'task_id','id');
    }
    /**
     * Get the task name that the timesheet belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo.
     */
    public function taskname()
    {
        return $this->belongsTo(Task::class,'project_id','project_id');
    }
}



