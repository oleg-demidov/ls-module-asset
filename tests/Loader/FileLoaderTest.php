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

/**
 * Description of TestLoaderFile
 *
 * @author oleg
 */
class FileLoaderTest extends \PHPUnit\Framework\TestCase{
    
    public function testLoad() {
        
        $loader = new \LS\Module\Asset\Loader\FileLoader(__DIR__.'/test.js');
        
        $asset = new \LS\Module\Asset\Asset\Asset($loader, []);
        
        $string = $loader->load($asset);
        
        $this->assertStringStartsWith('Testscript', $string);
        
    }
    
    
}
