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

/**
 * Description of WorkerMergeTest
 *
 * @author oleg
 */
class WorkerMergeTest extends TestCase{
   
    protected $factory;

    public function setUp() {
         $assets = [
            'js' => [
                'assetJsLocal' => array(
                    'file' => __DIR__.'/Loader/test.js', 
                    'filters' => [
                        'js_min'
                    ]
                ),
                'assetJsHTTP' => array(
                    'file' => 'https://code.jquery.com/jquery-3.4.1.js', 
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
                ]               
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
                
        $parser = new \LS\Module\Asset\ConfigParser($filters);
        
        $config = [
            'merge' => true,
            'filters' => []
        ];
        
        $this->factory = new \LS\Module\Asset\AssetFactory($config);
                
        $this->factory->setAssetManager($parser->parse($assets));
        
        $this->factory->setFilterManager($filters);
        
    }
    
    public function testWork() {
        $factory = clone $this->factory;
        
        $workerMerge = new \LS\Module\Asset\Worker\WorkerMerge();
        
        $mergeManager = $workerMerge->work($factory->createAssetType("js"), $factory);
        
        $this->assertTrue($mergeManager->getNames() === [
            'assetJsLocalassetJsHTTP',
            'assetJsRemote'], print_r($mergeManager->getNames(), true));
    }
}
