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
use Assetic\AssetManager;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\JSMinFilter;
use LS\Module\Asset\Asset\Asset;
use LS\Module\Asset\ConfigParser;
use LS\Module\Asset\FilterManager;
use LS\Module\Asset\Loader\FileLoader;
use LS\Module\Asset\Loader\RemoteLoader;
use PHPUnit\Framework\TestCase;

/**
 * Description of ParserTest
 *
 * @author oleg
 */
class ConfigParserTest extends TestCase{
    
    public function getFilterManager() {
        $filters = new FilterManager();
        
        $filters->set('js_min', new JSMinFilter());
        $filters->set('css_min', new CssMinFilter());
        
        return $filters;
    }
    
    public function getAssetManager() {
        $assets = [
            'js' => [
                'assetJsLocal' => array(
                    'file' => __DIR__.'/assets/test.js', 
                    'depends' => [
                        'assetJsHTTP'
                    ],
                    'filters' => [
                        'js_min'
                    ]
                ),
                'assetJsRemote' => [
                    'file' => 'https://code.jquery.com/jquery-3.4.1.js',
                    'loader' => RemoteLoader::class,
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
                ),
                
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
                
        $parser = new ConfigParser($this->getFilterManager());        
        
        return $parser->parse($assets);
    }
    
    public function testParse() {
        $am = $this->getAssetManager();
        
        $this->assertInstanceOf(AssetManager::class, $am);      
        
        $this->assertTrue(['assetJsLocal', 'assetJsRemote', 'assetJsHTTP', 'assetCssLocal'] === $am->getNames());
        
        foreach ($am->getNames() as $aName) {
            $this->assertInstanceOf(AssetInterface::class, $am->get($aName));
        }
        
        $aTetParams = [
            
            "file" => "/home/oleg/Develop/pdd-fend/vendor/livestreet/asset/tests/assets/test.js",
            "depends" => 
                [
                    'assetJsHTTP'
                ],
            "filters" => 
                [
                    'js_min'
                ],

            "loader" => "file",
            "merge" => true,
            "attr" => [ ]
        ];
        
        $this->assertTrue($am->get('assetJsLocal')->getParams() === $aTetParams, 
                print_r($am->get('assetJsLocal')->getParams(), true) . print_r($aTetParams, true));
        
    }
    
    public function testParseOne() {
        $am = $this->getAssetManager();
                
        $aTetParams = [
            
            "file" => "/home/oleg/Develop/pdd-fend/vendor/livestreet/asset/tests/assets/test.js",
            "depends" => 
                [
                    'assetJsHTTP'
                ],
            "filters" => 
                [
                    'js_min'
                ],

            "loader" => "file",
            "merge" => true,
            "attr" => [ ]
        ];
        
        $asset = new Asset(
            new FileLoader(__DIR__.'/assets/test.js'),
            [new JSMinFilter()],
            $aTetParams);
        $asset->setType('js');
        
        $this->assertTrue($am->get('assetJsLocal') == $asset, print_r($am->get('assetJsLocal'), true). print_r($asset, true));
    }
}
