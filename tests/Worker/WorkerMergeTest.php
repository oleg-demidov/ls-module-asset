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

use Assetic\Filter\CssMinFilter;
use Assetic\Filter\JSMinFilter;
use LS\Module\Asset\AssetFactory;
use LS\Module\Asset\ConfigParser;
use LS\Module\Asset\FilterManager;
use LS\Module\Asset\Worker\WorkerMerge;

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
                    'loader' => \LS\Module\Asset\Loader\RemoteLoader::class,
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
        
        $filters = new FilterManager();
        
        $filters->set('js_min', new JSMinFilter()); 
        $filters->set('css_min', new CssMinFilter());
                
        $parser = new ConfigParser($filters);
        
        $config = [
            'merge' => true,
            'filters' => []
        ];
        
        $this->factory = new AssetFactory($config);
                
        $this->factory->setAssetManager($parser->parse($assets));
        
        $this->factory->setFilterManager($filters);
        
    }
    
    public function testWork() {
        $factory = clone $this->factory;
        
        $workerMerge = new WorkerMerge();
        
        $mergeManager = $workerMerge->work($factory->createAssetType("js"), $factory);
        
        $aTest = [
            'merge_' . substr(md5('assetJsLocalassetJsHTTP'), 0, 5),
            'assetJsRemote'
        ];
        
        $this->assertTrue($mergeManager->getNames() == $aTest, 
                print_r($mergeManager->getNames(), true). print_r($aTest, true));
    }
}
