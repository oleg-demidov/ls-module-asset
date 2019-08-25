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

    public function setUp() {
         $assets = [
            'js' => [
                'assetJsLocal' => array(
                    'file' => __DIR__.'/Loader/test.js', 
                    'depends' => [
                        'assetJsHTTP'
                    ],
                    'filters' => [
                        'js_min'
                    ]
                ),
                'assetJsRemote' => [
                    'file' => 'https://code.jquery.com/jquery-3.4.1.js',
                    'loader' => "remote",
                    'merge' => false,
                    'filters' => [
                        'js_min'
                    ]
                ],
                'assetJsHTTP' => array(
                    'file' => 'https://code.jquery.com/jquery-3.4.1.js', 
                    'filters' => [
                        'js_min'
                    ]
                )                
            ],
            'css' => [
                'assetCssLocal' => array(
                    'file' => __DIR__.'/Loader/test.css',
                    'filters' => [
                        'css_min'
                    ]
                ),
            ]
        ];
        
        $filters = new \LS\Module\Asset\FilterManager();
        
        $filters->set('js_min', new \Assetic\Filter\JSMinFilter()); 
        $filters->set('css_min', new \Assetic\Filter\CssMinFilter());
                
        $parser = new ConfigParser($filters);
        
        $config = [
            'merge' => true,
            'filters' => []
        ];
        
        $this->factory = new AssetFactory($config);
                
        $this->factory->setAssetManager($parser->parse($assets));
        
        $this->factory->setFilterManager($filters);
        
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
        $factory = clone $this->factory;
        
        $assets = $factory->createAsset([
            'assetJsLocal'
        ]);
        
        $this->assertTrue(in_array('assetJsLocal', $assets->getNames()));
    }
    
    public function testCreateAssetDepend() {
        $factory = clone $this->factory;
        
        $factory->addWorker(new WorkerDepends());
        
        $assets = $factory->createAsset([
            'assetJsLocal'
        ]);
        
        $this->assertTrue(['assetJsHTTP', 'assetJsLocal'] === $assets->getNames());
        
    }
    
    public function testCreateAssetType() {
        
        $factory = clone $this->factory;
                
        $assets = $factory->createAssetType('js');
        
        $this->assertTrue([ 'assetJsLocal', 'assetJsRemote', 'assetJsHTTP'] === $assets->getNames());
    }
    
    public function testCreateAssetTypeCss() {
        
        $factory = clone $this->factory;
                
        $assets = $factory->createAssetType('css');
        
        $this->assertTrue([ 'assetCssLocal'] === $assets->getNames());
    }
}
