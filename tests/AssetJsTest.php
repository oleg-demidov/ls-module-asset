<?php

use PHPUnit\Framework\TestCase;
use LS\Module\Asset\Loader\FileLoader;

/**
 * Description of AssetJsTest
 *
 * @author oleg
 */
class JsAssetTest extends TestCase{
    
    protected $asset;
    
    public function setUp() {
        $this->asset = new JsAsset(
            new FileLoader(__DIR__.'/assets/test.js'),
            [
                new Assetic\Filter\JSMinFilter()
            ]            
        );
    }
    
    public function testLoad() {
                
        $this->asset->load();
        
        $this->assertStringStartsWith('\/\/Testscript', $asset->getContent());
    }
}
