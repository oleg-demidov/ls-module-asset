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
        
        $assetMerge = new \Assetic\Asset\AssetCollection();
        
        foreach ($workingAssets->getNames() as $name) {
            $asset = $workingAssets->get($name);
            
            if($asset->getParamsOne('merge')){
                
                $assetMerge->add($asset);
                
                $sNameMerge .= $name;
                
                continue;
            }
            
            $resultAssets->set($sNameMerge, $assetMerge);

            $sNameMerge = '';

            $assetMerge = new \Assetic\Asset\AssetCollection();

            $resultAssets->set($name, $asset);
        }
        
        if($sNameMerge !== ''){
            $resultAssets->set($sNameMerge, $assetMerge);
        }
        
        return $resultAssets;
    }

}
