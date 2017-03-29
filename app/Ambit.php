<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ambit extends Model
{
    use SoftDeletes;

    protected $fillable = array('id', 'ambit');

    public function project() {
        return $this->hasMany('Project');
    }

    protected $dates = ['deleted_at'];
}
