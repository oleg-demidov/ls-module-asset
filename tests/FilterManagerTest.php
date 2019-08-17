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
 * Description of FilterManagerTest
 *
 * @author oleg
 */
class FilterManagerTest extends TestCase{
    
    public function testGet() {
        $filters = new \LS\Module\Asset\FilterManager();
        
        $oneFilter = new \Assetic\Filter\CssMinFilter();
        $twoFilter = new \Assetic\Filter\JSMinFilter();
        
        $arrFilters = [
            $oneFilter,
            $twoFilter
        ];
        
        $filters->set('one', $oneFilter);
        $filters->set('two', $twoFilter);
        
        $this->assertTrue($filters->get(['one', 'two']) === $arrFilters);
    }
}
