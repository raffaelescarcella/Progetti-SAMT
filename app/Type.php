<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;

    protected $fillable = ['type'];

    public function user() {
        return $this->hasMany('User');
    }

    protected $dates = ['deleted_at'];

}
