<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseAuthorizationKey extends Model
{
    public function user()
    {
        $this->belongsTo('App/Warehouse','warehouse_id');
    }
}
