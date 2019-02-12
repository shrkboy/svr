<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    public $timestamps = false;

    public function users(){
        return $this->belongsTo('App\User','id_user');
    }

    public function branches(){
        return $this->belongsTo('App\Branch','id_branch');
    }

    public function documents(){
        return $this->hasMany('App\Document','id_report');
    }
}
