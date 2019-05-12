<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    public function shipment()
    {
        return $this->belongsTo('App/Shipment','shipment_id');
    }

    public function inventory()
    {
        return $this->belongsTo('App/WarehouseInventory','inventory_id');
    }
}
