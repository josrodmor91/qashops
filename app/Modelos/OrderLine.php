<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $table = "order_line";
    
    protected $fillable = [
        'product_id','quantity'
    ];
    
    public function ordenesBloqueadasPorPedidosEnCurso($productId){
        OrderLine::find()->select('SUM(quantity) as quantity')
        ->joinWith('order')->where("(order.status = '" .
            Order::STATUS_PENDING . "' OR order.status = '" .
            Order::STATUS_PROCESSING . "' OR order.status = '" .
            Order::STATUS_WAITING_ACCEPTANCE .
            "') AND order_line.product_id = $productId")
            ->scalar();
    }
}
