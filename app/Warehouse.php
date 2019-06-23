<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function users()
    {
        return $this->hasMany('App\User', 'warehouse_id', 'id');
    }

    public function shipments()
    {
        return $this->hasMany('App\Shipment', 'shipment_id');
    }

    public function returned_items()
    {
        return $this->hasMany('App\ReturnedItem', 'warehouse_id');
    }

    public function warehouse_authorization_key()
    {
        return $this->hasOne('App\WarehouseAuthorizationKey', 'warehouse_id');
    }

    public function manager_detail()
    {
        return $this->belongsTo('App\User', 'manager', 'id');
    }
}
