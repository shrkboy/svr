<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedItem extends Model
{
    public function inventory()
    {
        return $this->belongsTo('App\WarehouseInventory','inventory_id');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse','warehouse_id');
    }

    public function dealer()
    {
        return $this->belongsTo('App\Branch', 'dealer_id');
    }
}
