<?php

namespace App\Servicios\Product;

use App\Modelos\BlockedStock;
use App\Modelos\OrderLine;
use App\Modelos\ShopChannel;

class Product
{
    private $productId;
    private $quantityAvailable;
    private $cacheDuration;
    private $securityStockConfig;
    
    private $ordersQuantity;
    private $blockedStockQuantity;
    
    
    public static function stock(
        $productId,
        $quantityAvailable,
        $cache = false,
        $cacheDuration = 60,
        $securityStockConfig = null
    ) {
        $this->productId = $productId;
        $this->quantityAvailable = $quantityAvailable;
        $this->cacheDuration = $cacheDuration;
        $this->securityStockConfig = $securityStockConfig;
        
        if ($cache) {
            $this->ordersQuantity = $this->stockBloqueadoPorPedidosEnCurso();

            $this->blockedStockQuantity = $this->stockBloqueado();
        } else {
            $this->ordersQuantity = OrderLine::ordenesBloqueadasPorPedidosEnCurso($productId);

            $this->blockedStockQuantity = BlockedStock::ordenesBloqueadas($productId);
        }

        return $this->calcularUnidadesDisponibles();
    }
    
    public static function calcularUnidadesDisponibles()
    {
        $hayAlgunaDefinida = isset($this->ordersQuantity) || isset($this->blockedStockQuantity);
        $cantidadMayorQueCero = $this->quantityAvailable >= 0;
        
        if ($hayAlgunaDefinida && $cantidadMayorQueCero) {
            $this->quantityAvailable = $this->quantityAvailable - $this->ordersQuantity - $this->blockedStockQuantity;
        }
        
        if ($cantidadMayorQueCero) {
            $this->quantityAvailable = $this->calculaCantidad($this->quantityAvailable);
        }
        return $this->quantityAvailable;
    }
    
    public static function calculaCantidad($quantity)
    {
        if (!empty($this->securityStockConfig)) {
            $quantity = ShopChannel::applySecurityStockConfig(
                $quantity,
                $this->securityStockConfig->mode,
                $this->securityStockConfig->quantity
            );
        }
        return $quantity > 0 ? $quantity : 0;
     }


     public static function stockBloqueado()
    {
        return BlockedStock::getDb()->cache(
            BlockedStock::ordenesBloqueadas($this->productId), 
            $this->cacheDuration);
    }

    public static function stockBloqueadoPorPedidosEnCurso()
    {
        return OrderLine::getDb()->cache(
            OrderLine::ordenesBloqueadasPorPedidosEnCurso($this->productId),
            $this->cacheDuration);
    }

}

