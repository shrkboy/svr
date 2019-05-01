<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public function details()
    {
        return $this->hasMany('App/ShipmentDetail', 'shipment_id');
    }

    public function dealer()
    {
        return $this->belongsTo('App/Branch', 'dealer_id');
    }

    public function warehouse()
    {
        return $this->belongsTo('App/Warehouse', 'warehouse_id');
    }
}