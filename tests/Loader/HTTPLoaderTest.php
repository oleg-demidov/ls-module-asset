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
 * Description of HTTPLoaderTest
 *
 * @author oleg
 */
class HTTPLoaderTest extends TestCase{
    
    public function testLoad() {
        $loader = new \LS\Module\Asset\Loader\HttpLoader('https://code.jquery.com/jquery-3.3.1.slim.min.js');
        
        $string = $loader->load();
        
        $this->assertStringStartsWith($string, file_get_contents(__DIR__ . '/jquery-3.3.1.slim.min.js'));
    }
}
