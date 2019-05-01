<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function users()
    {
        $this->hasMany('App/User', 'warehouse_id');
    }

    public function shipments()
    {
        $this->hasMany('App/Shipment','shipment_id');
    }

    public function returned_items()
    {
        $this->hasMany('App/ReturnedItem','warehouse_id');
    }

    public function warehouse_authorization_key()
    {
        $this->hasOne('App/WarehouseAuthorizationKey','warehouse_id');
    }
}
