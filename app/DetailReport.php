<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailReport extends Model
{
    //
    public $timestamps = false;

    public function reports(){
        return $this->belongsTo('App\Report','id_report');
    }
}
