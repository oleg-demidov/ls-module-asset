<?php

use Assetic\Filter\JSMinFilter;
use LS\Module\Asset\Asset\JsAsset;
use LS\Module\Asset\Loader\FileLoader;
use PHPUnit\Framework\TestCase;

/**
 * Description of AssetJsTest
 *
 * @author oleg
 */
class JsAssetTest extends TestCase{
    
    protected $asset;
    
    public function setUp() {
        $this->asset = new JsAsset(
            new FileLoader(dirname(__DIR__).'/Loader/test.js'),
            [
                new JSMinFilter()
            ]            
        );
    }
    
    public function testLoad() {
                
        $this->asset->load();
        
        $this->assertTrue($this->asset->getTargetPath() === dirname(__DIR__).'/Loader/test.js');
        
        $this->assertStringStartsWith('Testscript', $this->asset->getContent());
    }
}
