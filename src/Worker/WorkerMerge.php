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

namespace LS\Module\Asset\Worker;

/**
 * Description of WorkerMerge
 *
 * @author oleg
 */
class WorkerMerge implements WorkerInterfase{
    //put your code here
    public function work(\LS\Module\Asset\AssetManager $workingAssets, \LS\Module\Asset\AssetFactory $factory) {
        $resultAssets = new \LS\Module\Asset\AssetManager();
        
        $sNameMerge = '';
        foreach ($workingAssets as $name) {
            
            if(!$asset->getParamsOne('merge')){
                $resultAssets->set($sNameMerge, clone $assetMerge);
                
                $assetMerge = new \Assetic\Asset\AssetCollection();
                
                $resultAssets->set($name, $workingAssets->get($name));
                continue;
            }
            
            $sNameMerge .= $name;
            
            $assetMerge->add($workingAssets->get($name));
            
            
        }
    }

}
