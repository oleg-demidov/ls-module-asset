<?php

use PHPUnit\Framework\TestCase;

/**
 * Description of AssetJsTest
 *
 * @author oleg
 */
class AssetJsTest extends TestCase{
    
    public function testLoad() {
        
        $asset = new LS\Module\Asset\AssetJs('https://sun9-23.userapi.com/c855532/v855532702/4edc/cHzMujuj8cU.jpg');
        
        $asset->load();
        
        $this->assertRegExp('/.+/', $asset->getContent());
    }
}
