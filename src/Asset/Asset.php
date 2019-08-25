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

use \Assetic\Asset\BaseAsset;
use \LS\Module\Asset\Loader\LoaderInterface;
/**
 * Description of AssetJs
 *
 * @author oleg
 */
class Asset extends BaseAsset{

    use AssetTrait;
    
    protected $loader;
    
    
    /**
     * 
     * @param LoaderInterface $loader
     * @param array $aFilters
     * @param array $aParams
     * @param array $aVars
     */
    public function __construct(LoaderInterface $loader, array $aFilters, array $aParams = [], array $aVars = []) {
        $this->loader = $loader;
        $this->aParams = $aParams;
        
        parent::__construct($aFilters, null, $this->loader->getSourcePath(), $aVars);
    }

    public function getLastModified() {
        return $this->loader->getLastModified();
    }

    public function load(\Assetic\Filter\FilterInterface $additionalFilter = null) {
        $this->doLoad($this->loader->load(), $additionalFilter);
        
        $this->setTargetPath($this->loader->getSourcePath());
    }
    
    
}
