<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id','user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function project(){
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function file(){
        return $this->hasMany('App\File');
    }

    protected $dates = ['deleted_at'];
}
