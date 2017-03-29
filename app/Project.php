<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'final_rating', 'password','state_id','start_date','end_date','year','ambit_id','name','user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function ambit() {
        return $this->belongsTo('App\Ambit','ambit_id');
    }

    public function projectstate() {
        return $this->belongsTo('App\ProjectState','state_id');
    }

    public function assignment(){
        return $this->hasMany('Assignment');
    }

    protected $dates = ['deleted_at'];
}
