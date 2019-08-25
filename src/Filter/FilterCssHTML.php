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

namespace LS\Module\Asset\Filter;

/**
 * Description of FilterCssHTML
 *
 * @author oleg
 */
class FilterCssHTML implements \Assetic\Filter\FilterInterface{
    
    protected $sTargetDir;
    
    public function setTargetDir(string $sTargetDir) {
        $this->sTargetDir = $sTargetDir;
    }

    public function filterDump(\Assetic\Asset\AssetInterface $asset) {
        $aParams = $asset->getParams();
        
        $element = new \DOMElement('link');
        
        foreach ($aParams['attr'] as $name => $value) {
            $element->setAttribute($name, $value);
        }
        
        $element->setAttribute('rel', 'stylesheet');
        
        $element->setAttribute('href', $this->sTargetDir . $asset->getTargetPath());
        
        $doc = new \DOMDocument();
        
        $asset->setContent($doc->saveHTML($element));
    }

    public function filterLoad(\Assetic\Asset\AssetInterface $asset) {
        
    }

}
