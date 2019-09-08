<?php

use Assetic\Filter\JSMinFilter;
use LS\Module\Asset\Asset\Asset;
use LS\Module\Asset\Loader\FileLoader;
use PHPUnit\Framework\TestCase;

/**
 * Description of AssetJsTest
 *
 * @author oleg
 */
class AssetTest extends TestCase{
    
    protected $asset;
    
    public function setUp() {
        $this->asset = new Asset(
            new FileLoader(dirname(__DIR__).'/Loader/test.js'),
            [
                new JSMinFilter()
            ]            
        );
    }
    
    public function testLoad() {
                
        $this->asset->load();
        
        
        $this->assertStringStartsWith('Testscript', $this->asset->getContent());
    }
}
