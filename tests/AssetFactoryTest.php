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
use LS\Module\Asset\AssetFactory;
use LS\Module\Asset\ConfigParser;
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
    
    protected $parseTest;


    public function setUp() {
        $config = [
            'merge' => true,
            'filters' => []
        ];
        
        $this->factory = new AssetFactory($config);
        
        $this->parseTest = new ConfigParserTest();   
        
        $this->factory->setAssetManager($this->parseTest->getAssetManager());
        
        $this->factory->setFilterManager($this->parseTest->getFilterManager());
        
    }
   
    public function testBuildHTML() {
        $assets = [
            'js' => [
                'assetJsLocal' => array(
                    'file' => __DIR__.'/assets/test.js', 
                    WorkerDepends::DEPENDS_KEY => [
                        'assetJsRemote'
                    ],
                    'filters' => [
                        'js_min'
                    ]
                ),
                'assetJsHttp' => [
                    'file' => 'https://code.jquery.com/jquery-3.4.1.js',
                    'merge' => false,
                    'filters' => [
                        'js_min'
                    ]
                ],                
                
            ],
        ];
                
        $parser = new ConfigParser($this->parseTest->getFilterManager());        
        
        $this->factory->setAssetManager($parser->parse($assets));
        
        $sHTML = $this->factory->buildHTML('js');
        
        $needString = '<script type="'.__DIR__.'/assets/test.js" src=""></script>'
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
    
    public function testCreateAsset() {
        $assets = $this->factory->createAsset([
            'assetJsLocal'
        ]);
        
        $aAssets = [];
        foreach ($assets as $asset) {
            $aAssets[] = $asset;
        }

        $this->assertTrue($aAssets[0]->getParams()['file'] === __DIR__.'/assets/test.js');
    }
    
    public function testCreateAssetDepend() {
        $this->factory->addWorker(new WorkerDepends());
        
        $assets = $this->factory->createAsset([
            'assetJsLocal'
        ]);
        
        $aAssets = [];
        foreach ($assets as $asset) {
            $aAssets[] = $asset;
        }
        
        $this->assertTrue($aAssets[0]->getParams()['file'] === __DIR__.'/assets/test.js');
        
        $this->assertArrayHasKey(1, $aAssets); 
        
        if(isset($aAssets[1])){
            $this->assertTrue($aAssets[1]->getParams()['file'] === 'https://code.jquery.com/jquery-3.4.1.js');
        }
    }
}
