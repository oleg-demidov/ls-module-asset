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
use Assetic\Filter\JSMinFilter;
use LS\Module\Asset\ConfigParser;
use LS\Module\Asset\FilterManager;
use LS\Module\Asset\Worker\WorkerDepends;
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
        
        return $filters;
    }
    
    public function getAssetManager() {
        $assets = [
            'js' => [
                'assetJsLocal' => array(
                    'file' => __DIR__.'/assets/test.js', 
                    WorkerDepends::DEPENDS_KEY => [
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
                ),
                
            ],
        ];
        
//        $am = new AssetManager();
//        $am->set('assetJsLocal', new \LS\Module\Asset\JsAsset(
//                new \LS\Module\Asset\Loader\FileLoader(__DIR__.'/assets/test.js'),
//                [new JSMinFilter()],
//                
//            ));
        
        $parser = new ConfigParser($this->getFilterManager());        
        
        return $parser->parse($assets);
    }
    
    public function testParse() {
        $am = $this->getAssetManager();
        
        $this->assertInstanceOf(AssetManager::class, $am);
        
        $this->assertTrue(['assetJsLocal', 'assetJsRemote', 'assetJsHTTP'] === $am->getNames());
        
        foreach ($am->getNames() as $aName) {
            $this->assertInstanceOf(AssetInterface::class, $am->get($aName));
        }
    }
}
