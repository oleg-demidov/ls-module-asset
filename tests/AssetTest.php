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

use LS\Module\Asset\Asset;

/**
 * Description of AssetTest
 *
 * @author oleg
 */
class AssetTest extends PHPUnit\Framework\TestCase{
    //put your code here
    
    public $asset;
    
    public function setUp() {
        $config = [
            'assetJsRemote' => new AssetJs(
                'https://code.jquery.com/jquery-3.4.1.js', 
                [
                    new Assetic\Filter\CssMinFilter
                ],
                [
                    'remote' => true
                ]
            ),
            'assetJsHTTP' => new AssetJs(
                'https://code.jquery.com/jquery-3.4.1.js', 
                [
                    new Assetic\Filter\CssMinFilter
                ]
            ),
            'assetJsLocal' => new AssetJs(__DIR__.'/assets/test.js', 
                [
                    new \Assetic\Filter\JSMinFilter()
                ], 
                [
                    Asset::DEPENDS_KEY => [
                        'assetJsHTTP'
                    ]
                ]
            )
        ];
        
        $this->assets = new Asset($config);
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
