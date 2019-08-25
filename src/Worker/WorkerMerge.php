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

use LS\Module\Asset\Asset\AssetCollection;
use LS\Module\Asset\AssetFactory;
use LS\Module\Asset\AssetManager;

/**
 * Description of WorkerMerge
 *
 * @author oleg
 */
class WorkerMerge implements WorkerInterfase{

    public function work(AssetManager $workingAssets, AssetFactory $factory) {
        $resultAssets = new AssetManager();
        
        $sNameMerge = '';
        
        $assetMerge = new AssetCollection();
        
        foreach ($workingAssets->getNames() as $name) {
            $asset = $workingAssets->get($name);
            
            if($asset->getParamsOne('merge') and $assetMerge->suitableForMerging($asset)){
                
                $assetMerge->add($asset);
                
                $assetMerge->setParams(['attr' => $asset->getParams()['attr']]);
                
                $sNameMerge .= $name;
                
                continue;
            }
            
            $assetMerge->setType($asset->getType());
            
            $resultAssets->set($sNameMerge, $assetMerge);

            $sNameMerge = '';

            $assetMerge = new AssetCollection();

            $resultAssets->set($name, $asset);
        }
        
        if($sNameMerge !== ''){
            $assetMerge->setType($asset->getType());
            
            $resultAssets->set($sNameMerge, $assetMerge);
        }
        
        return $resultAssets;
    }
    

}
