<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected const STATUS_PENDING = 'Pendiente';
    
    protected $table = "shopping_cart";
    
    protected $fillable = [
        'status'
    ];
}
