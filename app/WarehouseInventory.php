<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseInventory extends Model
{
    public $timestamps = false;

    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse','warehouse_id');
    }

    public function shipment_detail()
    {
        return $this->hasOne('App\ShipmentDetail','inventory_id');
    }

    public function returned_item()
    {
        return $this->hasOne('App\ReturnedItem','inventory_id');
    }

    public function bike_model()
    {
        return $this->belongsTo('App\BikeModel', 'bike_model_id');
    }
}
