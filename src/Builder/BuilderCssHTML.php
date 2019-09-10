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
class BuilderCssHTML implements BuilderInterface{

    protected $document;
    
    protected $sTargetDir;
    
    protected $aDefaultAttr;
    
    use BuilderTrait;

    public function __construct(string $sTargetDir, array $aDefaultAttr = []) {
        $this->document = new \DOMDocument();
        $this->document->formatOutput = true;
        
        $this->aDefaultAttr = $aDefaultAttr;
        
        $this->sTargetDir = $sTargetDir;
    }
    
    public function add(\Assetic\Asset\AssetInterface $asset) {
        $aParams = $asset->getParams();
                
        $element = $this->document->createElement('link');
        
        $aAttr = array_merge($this->aDefaultAttr, $aParams['attr']);
        
        foreach ($aAttr as $name => $value) {
            $this->setAttribute($element, $name, $value);
        }
        
        $element->setAttribute('rel', 'stylesheet');
        /*
         * Путь до ресурса должен сформировать загргузчик
         */
        $sResultPath = $asset->loader->getResultPath($this->sTargetDir, $asset->getTargetPath());
        
        $element->setAttribute('href', $sResultPath);
        
        $this->document->appendChild($element);
    }

    public function build(): string {       
        
        return preg_replace('/^.+\n/', '', $this->document->saveXML());
    }

}
