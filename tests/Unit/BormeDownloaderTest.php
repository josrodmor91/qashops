<?php

namespace Tests\Unit;

use Tests\TestCase;
use DomainException;
use ErrorException;
use App\Servicios\Borme\BormeDownloader;

class BormeDownloaderTest extends TestCase
{
    private $bormeDownloaderServicio;
    
    /**
     * @before
     */
    public function setServicioBormeDownloader()
    {
        $this->bormeDownloaderServicio = new BormeDownloader();
    }
    
    public function testURLValidaTest()
    {
        $url = 'https://www.boe.es/borme/dias/2017/01/10/pdfs/BORME-A-2017-6-41.pdf';
        $this->assertTrue($this->bormeDownloaderServicio->esURLValida($url));
    }
    
    public function testURLPDFTest()
    {
        $url = 'https://www.boe.es/borme/dias/2017/01/10/pdfs/BORME-A-2017-6-41.pdf';
        $this->assertTrue($this->bormeDownloaderServicio->esURLConPDF($url));
    }
    
    public function testParseaPdfFalloTest()
    {
        $this->expectException(ErrorException::class);
        $url = 'https://www.boe.es/borme/dias/2017/01/10/';
        $this->assertTrue($this->bormeDownloaderServicio->parseaPDF($url));
    }
    
    public function testURLValidaFallaTest()
    {
        $this->expectException(DomainException::class);
        $url = 'https:///borme/dias/2017/01/10/pdfs';
        $this->bormeDownloaderServicio->esURLValida($url);
    }
    
    public function testURLPDFFallaTest()
    {
        $this->expectException(DomainException::class);
        $url = 'https://www.boe.es/borme/dias/2017/01/10/pdfs/BORME-A-2017';
        $this->bormeDownloaderServicio->esURLConPDF($url);
    }
    
}