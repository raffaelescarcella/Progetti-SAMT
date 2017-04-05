<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileType extends Model
{
    use SoftDeletes;

    protected $fillable = ['type'];

    public function user() {
        return $this->hasMany('File');
    }

    protected $dates = ['deleted_at'];

}
