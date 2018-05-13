<?php

namespace App\Servicios\Borme;

class DescargarFicheroServicio
{
    protected $destino_ruta;
    protected $fuente_url;
    
    public function __construct($destino_ruta, $fuente_url){
        $this->destino_ruta = $destino_ruta;
        $this->fuente_url = $fuente_url;
    }
    
    public function descargarFicheroEnRuta($reintentos){
        
        try{
            $this->creaRutaDescargaSiNoExiste();
            
            $this->obtieneFichero($reintentos);
            
            return true;
        }catch (\InvalidArgumentException $e){
            throw $e;
        }catch (\ErrorException $e){
            throw $e;
        }
    }
    
    public function obtieneFichero($reintentos){
        $descarga = false;
        $reintentos_realizados = 0;
        
        while ($descarga === false && $reintentos > $reintentos_realizados) {
            $descarga = copy($this->fuente_url,$this->destino_ruta.basename($this->fuente_url));
            $reintentos_realizados++;
        }
        
        if(false === $descarga){
            throw new \ErrorException("Tras varios reintentos no se pudo descargar el fichero.");
        }
        
        return true;
    }
    
    public function creaRutaDescargaSiNoExiste(){
        try{
            if(!file_exists($this->destino_ruta)){
                $exito = mkdir ($this->destino_ruta);
                if(false === $exito){
                    throw new \InvalidArgumentException("No se pudo guardar el fichero en la ruta especificada.");
                }
            }
        }catch (\ErrorException $e){
            throw new \InvalidArgumentException("No se pudo guardar el fichero en la ruta especificada.");
        }
        
        return true;
    }
}