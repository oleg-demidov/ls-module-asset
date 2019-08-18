<?php

/*
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: end-fin@yandex.ru
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link https://vk.com/u_demidova
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author Oleg Demidov <end-fin@yandex.ru>
 *
 */

namespace PHPUnit\Framework;

use Assetic\Asset\FileAsset;
use LS\Module\Asset\AssetManager;

/**
 * Description of AssetManagerTest
 *
 * @author oleg
 */
class AssetManagerTest extends TestCase{
  
    protected $assets;


    public function setUp() {
        $this->assets = new AssetManager();
    }
    
    public function testRemove() {
        $this->assets->set('test', new FileAsset(''));
        
        $this->assertTrue($this->assets->has('test'));
        
        $this->assets->remove('test');
        
        $this->assertFalse($this->assets->has('test'));
    }
}
