<?php

namespace App\Servicios\Borme;

use Illuminate\Support\Facades\App;
use Smalot\PdfParser\Parser;

class BormeDownloader
{
    //Podría ponerse en un fichero de configuración en la carpeta config
    private $directorio_destino = "C://temp/";
    private $reintentos = 3;
    
    public function __construct(){
    }
    
    public function downloadBorme($url){
        try{
            $this->esURLValida($url);
            
            $this->esURLConPDF($url);
            
            $this->descargaFicheroServicio = new DescargarFicheroServicio(
                $this->directorio_destino, $url);
            $this->descargaFicheroServicio->descargarFicheroEnRuta($this->reintentos);
            
            $text_pdf = $this->parseaPDF($url);
            
            $nombre_fichero = $this->escribeTextoEnTxt($url, $text_pdf);
            
            return "Fichero $nombre_fichero descargado en: ".$this->directorio_destino;
            
        }catch (\DomainException $e){
            echo $e -> getMessage();
        }catch (\InvalidArgumentException $e){
            echo $e -> getMessage();
        }catch (\ErrorException $e){
            echo $e -> getMessage();
        }
    }
    
    public function escribeTextoEnTxt($url, $text_pdf){
        $nombre_fichero = basename($url, ".pdf").".txt";
        
        $escritura = file_put_contents($this->directorio_destino.$nombre_fichero,$text_pdf);
        if($escritura === false) {
            throw new \Exception("No se ha podido crear el fichero $nombre_fichero");
        }
        
        $borrado = unlink($this->directorio_destino.basename($url));
        if($borrado === false) {
            throw new \Exception("No se ha podido eliminar el fichero ".basename($url));
        }
        
        return $nombre_fichero;
    }
    
    public function parseaPDF($url) {
        $parser = new Parser();
        $ruta_lectura = $this->directorio_destino.basename($url);
        
        $pdf = $parser->parseFile($ruta_lectura);
        return $texto_pdf = $pdf->getText();
    }
    
    public function esURLValida($url) {
        if(filter_var($url,FILTER_VALIDATE_URL)){
            return true;
        }else{
            throw new \DomainException('La URL no es válida');
        }
    }
    
    public function esURLConPDF($url) {
        if (!in_array("Content-Type: application/pdf", get_headers($url))){
            throw new \DomainException('La URL no hace referencia a un PDF');
        }
        return true;
    }
}
