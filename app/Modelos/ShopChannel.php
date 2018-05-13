<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ShopChannel extends Model
{
    public function applySecurityStockConfig($quantity, $mode_config, $quantity_config){
        //No se lo que hace
        return $quantity;
    }
}
