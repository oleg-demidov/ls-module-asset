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

namespace LS\Module\Asset\Asset;

/**
 * Description of AssetCollection
 *
 * @author oleg
 */
class AssetCollection extends \Assetic\Asset\AssetCollection{
    use AssetTrait;
    
    public function getSourcePath() {
        return current($this->all())->getSourcePath();
    }
    
    public function suitableForMerging(\Assetic\Asset\AssetInterface $asset) {
        if(!count($this->all())){
            return true;
        }
        
        if($asset->getParamsOne('publicDir') !== $this->getParamsOne('publicDir')){
            return false;
        }
        
        if($asset->getParamsOne('attr') !== $this->getParamsOne('attr')){
            return false;
        }
        
        return true;
    }
}
