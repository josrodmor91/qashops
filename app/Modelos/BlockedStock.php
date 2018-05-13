<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class BlockedStock extends Model
{
    protected $table = "blocked_stock";
    
    protected $fillable = [
        'product_id','shopping_cart_id','quantity','blocked_stock_date'
    ];
    
    public function ordenesBloqueadas($productId){
        return BlockedStock::find()->
            select('SUM(quantity) as quantity')
            ->joinWith('shoppingCart')
            ->where(
                "blocked_stock.product_id = $productId AND
                blocked_stock_date > '" . date('Y-m-d H:i:s') .
                "'AND (shopping_cart_id IS NULL OR shopping_cart.status = '" .
                ShoppingCart::STATUS_PENDING . "')"
            )->scalar();
    }
}
