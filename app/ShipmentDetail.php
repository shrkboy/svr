<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    public function shipment()
    {
        $this->belongsTo('App/Shipment','shipment_id');
    }

    public function bike_model()
    {
        $this->belongsTo('App/BikeModel','bike_model_id');
    }
}
