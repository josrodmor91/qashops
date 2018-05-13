<?php

namespace Tests\Unit;

use Tests\TestCase;
use DomainException;
use ErrorException;
use InvalidArgumentException;
use App\Servicios\Borme\BormeDownloader;
use App\Servicios\Borme\DescargarFicheroServicio;

class DescargaFicheroTest extends TestCase
{
    private $descargaFicheroServicio;
    private $descargaFicheroServicioFallo;
    
    /**
     * @before
     */
    public function setServicioBormeDownloader()
    {
        $this->descargaFicheroServicio = new DescargarFicheroServicio("C://temp/", 
            'https://www.boe.es/borme/dias/2017/01/10/pdfs/BORME-A-2017-6-41.pdf');
        
        $this->descargaFicheroServicioFallo = new DescargarFicheroServicio("BAR://temp/",
            'hts:///www..es/borme/dias/2017/01/10/pdfs/BORME-A-2017-6-41.pdf');
    }
    
    public function testDescargarFicheroEnRutaTest()
    {
        $this->assertTrue($this->descargaFicheroServicio->descargarFicheroEnRuta(3));
    }
    
    public function testObtieneFicheroTest()
    {
        $this->assertTrue($this->descargaFicheroServicio->obtieneFichero(3));
    }
    
    public function testObtieneFicheroFallaTest()
    {
        $this->expectException(ErrorException::class);
        $this->descargaFicheroServicio->obtieneFichero(0);
    }
    
    public function testObtieneFicheroRutasFallaTest()
    {
        $this->expectException(ErrorException::class);
        $this->descargaFicheroServicioFallo->obtieneFichero(3);
    }
    
    public function testCreaRutaDescargaSiNoExisteTest()
    {
        $this->assertTrue($this->descargaFicheroServicio->creaRutaDescargaSiNoExiste());
    }
    
    public function testCreaRutaDescargaSiNoExisteFallaTest()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->descargaFicheroServicioFallo->creaRutaDescargaSiNoExiste();
    }
}