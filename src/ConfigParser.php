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

use Assetic\FilterManager;
use LS\Module\Asset\Asset\Asset;
use LS\Module\Asset\Loader\HttpLoader;
use LS\Module\Asset\Loader\LoaderInterface;
use LS\Module\Asset\ParserException;
use LS\Module\Asset\Worker\WorkerDepends;
use OutOfBoundsException;

/**
 * Description of ConfigParser
 *
 * @author oleg
 */
class ConfigParser {
    
    protected $filters;
    
    public function __construct(FilterManager $filters = null) {
        $this->filters = $filters;
    }
    
    public function parse($aConfig) {
        
        $assetManager = new AssetManager();
            
        foreach ($aConfig as $sType => $aAssets) { 
            
            $this->normalizeAssetConfig($aAssets);
            
            foreach ($aAssets as $sName => $mAsset) {
                
                $asset = new Asset(
                    $this->getLoaderFromAssetConfig($mAsset),
                    $this->filters->get($mAsset['filters']),
                    $mAsset
                );
                
                $asset->setType($sType);
                
                $assetManager->set($sName, $asset);
            }
        }
        
        return $assetManager;
    }
    
    /**
     * 
     * @param array $aAsset
     * 
     * @return LoaderInterface
     * 
     * @throws ParserException
     */
    public static function getLoaderFromAssetConfig(array $aAsset) {
        if(!$aAsset['loader']){
            return null;
        }
        
        if (false !== strpos($aAsset['file'], '://') || 0 === strpos($aAsset['file'], '//')) {
            return new HttpLoader($aAsset['file']);
        }
        
        $sClass = 'LS\\Module\\Asset\\Loader\\' . ucfirst($aAsset['loader']) . 'Loader';
        
        if(!class_exists($sClass)){
            throw new OutOfBoundsException("Class loader {$sClass} not found");
        }

        return new $sClass($aAsset['file']);
    }
    
    /**
     * Принимает список ресурсов в виде конфига
     * Изменяет его в удобный для преобразования в ресурсы массив
     * 
     * @param array $aAssets
     */
    public static function normalizeAssetConfig(array &$aAssets){

        
        foreach ($aAssets as $sName => $mAsset) {
            $aAssetNew = $mAsset;
            $sNameNew = $sName;

            if(is_int($sName)){
                $sNameNew = preg_replace('/\..+$/i', '', basename($mAsset));
            }

            if(is_string($mAsset)){
                $aAssetNew = [
                    'file' => $mAsset
                ];
            }

            if(isset($mAsset['name'])){
                $sNameNew = $mAsset['name'];
            }

            unset($aAssets[$sName]);            
            
            $aAssetNew['file'] = (isset($aAssetNew['file']) ) ? $aAssetNew['file'] : '';
            $aAssetNew['filters'] = (isset($aAssetNew['filters']) ) ? $aAssetNew['filters'] : [];
            $aAssetNew['loader'] = (isset($aAssetNew['loader']) ) ? $aAssetNew['loader'] : "file";
            $aAssetNew['merge'] = (isset($aAssetNew['merge']) and !$aAssetNew['merge']) ? false : true;
            $aAssetNew['attr'] = (isset($aAssetNew['attr']) and is_array($aAssetNew['attr'])) ? $aAssetNew['attr'] : [];
            $aAssetNew['depends'] = (isset($aAssetNew['depends'])) ? $aAssetNew['depends']  : [];
            
            $aAssets[$sNameNew] = $aAssetNew;
        }
        
        
    }

}
