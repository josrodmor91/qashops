<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected const STATUS_PENDING = 'Pendiente';
        
    protected const STATUS_PROCESSING = 'Procesando';
            
    protected const STATUS_WAITING_ACCEPTANCE = 'Esperando aceptación';
    
    protected $table = "order";
    
    protected $fillable = [
        'status'
    ];
}
