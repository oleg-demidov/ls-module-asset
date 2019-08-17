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

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;
use LS\Module\Asset\AssetFactory;
use LS\Module\Asset\Worker\WorkerDepends;
use PHPUnit\Framework\TestCase;

/**
 * Description of AssetTest
 *
 * @author oleg
 */
class AssetFactoryTest extends TestCase{
    //put your code here
    
    public $factory;
    
    public function setUp() {
        $config = [
            'merge' => true,
            'filters' => []
        ];
        
        $this->factory = new AssetFactory($config);
        
        $parseTest = new ConfigParserTest();   
        
        $this->factory->setAssetManager($parseTest->getAssetManager());
        
        $this->factory->setFilterManager($parseTest->getFilterManager());
        
    }
   
    public function testBuildHTML() {
        $sHTML = $this->factory->buildHTML('js');
        
        $needString = '<script type="'.__DIR__.'/assets/test.js" src=""></script>'
                . '<script type="https://code.jquery.com/jquery-3.4.1.js" src=""></script>'
                . '<script type="https://code.jquery.com/jquery-3.4.1.js" src=""></script>';
        
        $this->assertTrue($needString === $sHTML);
    }
    /**
     * Тестирование удаленного ресурса js
     */
    public function testAssetJsRemote() {   
        $this->assertInstanceOf(AssetInterface::class, $this->factory->get('assetJsRemote'));
    }
    
    public function testAssetJsHTTP() {
        $this->assertInstanceOf(AssetInterface::class, $this->factory->get('assetJsHTTP'));
    }
    
    public function testAssetJsLocal() {
        $this->assertInstanceOf(AssetInterface::class, $this->factory->get('assetJsLocal'));
    }
}
