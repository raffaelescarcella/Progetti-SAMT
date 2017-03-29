<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'date','assignment_id'
    ];

    public function assignments(){
        return $this->belongsTo('App\Assignments', 'assignment_id');
    }

    protected $dates = ['deleted_at'];
}
