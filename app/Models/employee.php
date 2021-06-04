<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_id',
        'fname',
        'lname',
        'phone',
        'email',
        'gender',
        'address',
        'salary',
        'dep_id',
        'team_id',
    ];

    /**
     * Get the department that the employee belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function depart()
    {
        return $this->belongsTo(Department::class,'dep_id','dep_id');
    }
    /**
     * Get the team that the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class,'team_id','id');
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setlnameAttribute($value)
    {
        $this->attributes['lname'] = strtolower($value);
    }
    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFullNameAttribute()       
    {        
        return $this->fname.$this->lname;         
    }
}




