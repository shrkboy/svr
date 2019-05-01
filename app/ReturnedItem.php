<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedItem extends Model
{
    public function bike_model()
    {
        $this->belongsTo('App/BikeModel','bike_model_id');
    }

    public function warehouse()
    {
        $this->belongsTo('App/Warehouse','warehouse_id');
    }
}
