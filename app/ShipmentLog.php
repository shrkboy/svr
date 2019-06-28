<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentLog extends Model
{
    public function by_detail()
    {
        return $this->belongsTo('App\User', 'by', 'id');
    }
}
