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

namespace LS\Module\Asset;

/**
 * Description of FilterManager
 *
 * @author oleg
 */
class FilterManager extends \Assetic\FilterManager{
    
    /**
     * Расширение метода для работы с массивами
     * 
     * @param mixed $alias
     * @return type
     */
    public function get($alias) {
        
        if(is_array($alias)){
            $aResult = [];
            
            foreach ($alias as $key){
                $aResult[] = parent::get($key);
            }
            
            return $aResult;
        }
        
        return parent::get($alias);
    }
    
     
    public function __clone() {
        foreach ($this->getNames() as $name) {
            $this->set($name, clone $this->get($name));
        }
    }
}
