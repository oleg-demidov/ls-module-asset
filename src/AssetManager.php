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
 * Description of AssetManager
 *
 * @author oleg
 */
class AssetManager extends \Assetic\AssetManager{
    
    public function remove($alias) {
        
        $aKeys = $this->getNames();
        
        if(!is_array($alias)){
            $alias = [$alias];
        }
        
        $assets = [];
        
        foreach ($aKeys as $key) {
            if(in_array($key, $alias)){
                continue;
            }
            $assets[$key] = $this->get($key);
        }
        
        
        $aKeys = array_diff($aKeys, $alias);
        
        $this->clear();
        
        foreach ($assets as $key => $asset) {
            $this->set($key, $asset);
        }        
    }
    
    public function __clone() {
        foreach ($this->getNames() as $name) {
            $this->set($name, clone $this->get($name));
        }
    }
}
