<?php

namespace App\Http\Controllers;

use App\Servicios\Borme\BormeDownloader;

class BormeController extends Controller
{
    protected $bormeDownloader;
    private $url_descarga = "https://www.boe.es/borme/dias/2017/01/10/pdfs/BORME-A-2017-6-41.pdf";
    
    public function index(){
        $this->bormeDownloader = new BormeDownloader();
        $fichero_resultado =  $this->bormeDownloader->downloadBorme($this->url_descarga);
        return $fichero_resultado;
    }
}
