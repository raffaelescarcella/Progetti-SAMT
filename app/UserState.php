<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserState extends Model
{
    use SoftDeletes;

    protected $fillable = array('state');

    public function user() {
        return $this->hasMany('User');
    }

    protected $dates = ['deleted_at'];
}
