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

use LS\Module\Asset\Assets;

/**
 * Description of AssetTest
 *
 * @author oleg
 */
class AssetsTest extends PHPUnit\Framework\TestCase{
    //put your code here
    
    public $asset;
    
    public function setUp() {
        $config = [
            'filters' => [
                'css_min' => new Assetic\Filter\CssMinFilter(),
                'js_min' => new Assetic\Filter\JSMinFilter()
            ]
        ];
        $assets = [
            'assetJsRemote' => new AssetJs(
                'https://code.jquery.com/jquery-3.4.1.js', 
                [
                    'remote' => true,
                    'filters' => [
                        'js_min'
                    ]
                ]
            ),
            'assetJsHTTP' => new AssetJs(
                'https://code.jquery.com/jquery-3.4.1.js', 
                [
                    'filters' => [
                        'js_min'
                    ]
                ]
            ),
            'assetJsLocal' => new AssetJs(
                __DIR__.'/assets/test.js', 
                [
                    Assets::DEPENDS_KEY => [
                        'assetJsHTTP'
                    ],
                    'filters' => [
                        'js_min'
                    ]
                ]
            )
        ];
        
        $this->assets = new Assets($config);
        
        $this->assets->load($assets);
    }

    /**
     * Тестирование удаленного ресурса js
     */
    public function testAssetJsRemote() {
        $this->assertInstanceOf(LS\Module\Asset\RemoteAsset::class, $this->assets->get('assetJsRemote'));
        
    }
    
    public function testAssetJsHTTP() {
        $this->assertInstanceOf(Assetic\Asset\HttpAsset::class, $this->assets->get('assetJsHTTP'));
    }
    
    public function testAssetJsLocal() {
        $this->assertInstanceOf(Assetic\Asset\FileAsset::class, $this->assets->get('assetJsLocal'));
    }
}
