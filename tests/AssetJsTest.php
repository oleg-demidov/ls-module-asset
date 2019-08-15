<?php

use PHPUnit\Framework\TestCase;

/**
 * Description of AssetJsTest
 *
 * @author oleg
 */
class AssetJsTest extends TestCase{
    
    protected $jsAsset;
    
    protected $loader;

    public function setUp($param) {
        $this->jsAsset = new jsAsset(
            [
                new Assetic\Filter\JSMinFilter()
            ],
            __DIR__.'/assets',
            'test.js',
            [],
            new LS\Module\Asset\Loader()
        );
    }
    
    public function testLoad() {
        
        $asset = new LS\Module\Asset\AssetJs('https://sun9-23.userapi.com/c855532/v855532702/4edc/cHzMujuj8cU.jpg');
        
        $asset->load();
        
        $this->assertRegExp('/.+/', $asset->getContent());
    }
}
