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
 * Description of WorkerDepends
 *
 * @author oleg
 */
class WorkerDepends implements WorkerInterfase{

 
    protected $factory;
    /**
     * 
     * @param \LS\Module\Asset\AssetManager $assets
     */
    public function work(\LS\Module\Asset\AssetManager $workingAssets,\LS\Module\Asset\AssetFactory $factory) {
        
        $this->factory = $factory;
        
        $resultAssets = new \LS\Module\Asset\AssetManager();
                
        foreach ($workingAssets->getNames() as $sName) {
            $this->addWithDepends($sName, $resultAssets);
        }
        
        
        return $resultAssets;
    }
    /**
     * 
     * @param string $sName
     * @param \LS\Module\Asset\AssetManager $assets
     */
    protected function addWithDepends(string $sName, \LS\Module\Asset\AssetManager $resultAssets ) {
        
        if($resultAssets->has($sName)){
            return;
        }
        
        $asset = $this->factory->getAssetManager()->get($sName);
        
        $aParams = $asset->getParams();
        
        if(isset($aParams['depends'])){    
            foreach ($aParams['depends'] as $sNameDepend) {
                $this->addWithDepends($sNameDepend, $resultAssets);
            }
            
        }

        $resultAssets->set($sName, $asset);

    }
}
