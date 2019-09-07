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

namespace LS\Module\Asset\Builder;

/**
 * Description of BuilderJsHTML
 *
 * @author oleg
 */
class BuilderJsHTML implements BuilderInterface{

    protected $document;
    
    protected $sTargetDir;

    public function __construct(string $sTargetDir) {
        $this->document = new \DOMDocument();
        $this->document->formatOutput = true;
        
        $this->sTargetDir = $sTargetDir;
    }
    
    public function add(\Assetic\Asset\AssetInterface $asset) {
        $aParams = $asset->getParams();
                
        $element = $this->document->createElement('script');
        
        foreach ($aParams['attr'] as $name => $value) {
            $element->setAttribute($name, $value);
        }
        
        $element->setAttribute('src', $this->sTargetDir . '/' . $asset->getTargetPath());
        
        $this->document->appendChild($element);
    }

    public function build(): string {
        return preg_replace('/^.+\n/', '', $this->document->saveXML());
    }

}
