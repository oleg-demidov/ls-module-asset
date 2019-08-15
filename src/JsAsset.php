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

use \Assetic\Asset\BaseAsset;
use \LS\Module\Asset\Loader\LoaderInterface;
/**
 * Description of AssetJs
 *
 * @author oleg
 */
class JsAsset extends BaseAsset{

    protected $loader;
    
    /**
     * 
     * @param LoaderInterface $loader
     * @param array $aFilters
     * @param array $aParams
     */
    public function __construct(LoaderInterface $loader, array $aFilters, array $aParams = []) {
        $this->loader = $loader;
    }

    public function getLastModified() {
        return null;
    }

    public function load(\Assetic\Filter\FilterInterface $additionalFilter = null) {
        
    }

}
