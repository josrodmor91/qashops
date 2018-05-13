<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BormeFeatureTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBormeTest()
    {
        $response = $this->get('/descargarBorme');
        
        $response->assertSee("Fichero BORME-A-2017-6-41.txt descargado en: C://temp/");
    }
    
    public function testBormeFalloTest()
    {
        $response = $this->get('/descargarBorme/rutaNoVálida');
        
        $response->assertStatus(404);
    }
}