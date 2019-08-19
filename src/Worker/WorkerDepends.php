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

    const DEPENDS_KEY = 'dependencies';
    
    protected $dependsAssets;

    public function __construct() {
        $this->dependsAssets = new \LS\Module\Asset\AssetManager();
    }
    /**
     * 
     * @param \LS\Module\Asset\AssetManager $assets
     */
    public function work(\LS\Module\Asset\AssetManager $assets) {
        
        foreach ($assets->getNames() as $sName) {
            $this->addWithDepends($sName, $assets);
        }
        
        return $this->dependsAssets;
    }
    /**
     * 
     * @param string $sName
     * @param \LS\Module\Asset\AssetManager $assets
     */
    protected function addWithDepends(string $sName, \LS\Module\Asset\AssetManager $assets ) {
        
        if($this->dependsAssets->has($sName)){
            return;
        }
        
        $asset = $assets->get($sName);
        
        $aParams = $asset->getParams();
        
        if(isset($aParams[self::DEPENDS_KEY])){    
            foreach ($aParams[self::DEPENDS_KEY] as $sNameDepend) {
                $this->addWithDepends($sNameDepend, $assets);
            }
            
        }

        $this->dependsAssets->set($sName, $assets->get($sName));

    }
}
