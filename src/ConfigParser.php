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
use LS\Module\Asset\Loader\HttpLoader;
use LS\Module\Asset\ParserException;

/**
 * Description of ConfigParser
 *
 * @author oleg
 */
class ConfigParser {
    
    protected $filters;
    
    public function __construct(FilterManager $filters) {
        $this->filters = $filters;
    }
    
    public function parse($aConfig) {
        
        foreach ($aConfig as $sType => $aAssets) { 
            $this->normalizeAssetConfig($aAssets);
            
            $sClass = "LS\\Module\\Asset\\Asset\\" . ucfirst($sType) . 'Asset';
            
            if(!class_exists($sClass)){
                throw new ParserException("Class {$sClass} not found");
            }
            
            $assetManager = new AssetManager();
            
            foreach ($aAssets as $sName => $mAsset) {
                $asset = new $sClass(
                    $this->getLoaderFromAssetConfig($sClass, $mAsset),
                    $this->filters->get($mAsset['filters']),
                    $mAsset
                );
                
                $assetManager->set($sName, $asset);
            }
        }
        
        return $assetManager;
    }
    
    /**
     * 
     * @param string $sPath
     * @param array $aAsset
     * 
     * @return \LS\Module\Asset\Loader\LoaderInterface
     * 
     * @throws ParserException
     */
    public static function getLoaderFromAssetConfig(string $sPath, array $aAsset) {
        if(!$aAsset['loader']){
            return null;
        }
        
        if (false !== strpos($sPath, '://') || 0 === strpos($sPath, '//')) {
            return new HttpLoader($sPath);
        }
        
        $sClass = 'LS\\Module\\Asset\\Loader\\' . ucfirst($aAsset['loader']) . 'Loader';
        
        if(!class_exists($sClass)){
            throw new ParserException("Class loader {$sClass} not found");
        }
        
        return new $sClass($sPath);
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
            
            $aAssetNew['file'] = (isset($aAssetNew['file']) ) ? $aAssetNew['file'] : null;
            $aAssetNew['loader'] = (isset($aAssetNew['loader']) ) ? $aAssetNew['loader'] : "file";
            $aAssetNew['merge'] = (isset($aAssetNew['merge']) and !$aAssetNew['merge']) ? false : true;
            $aAssetNew['browser'] = (isset($aAssetNew['browser']) and $aAssetNew['browser']) ? $aAssetNew['browser'] : null;
            $aAssetNew['plugin'] = (isset($aAssetNew['plugin']) and $aAssetNew['plugin']) ? $aAssetNew['plugin'] : null;
            $aAssetNew['attr'] = (isset($aAssetNew['attr']) and is_array($aAssetNew['attr'])) ? $aAssetNew['attr'] : [];
            $aAssetNew[Worker\WorkerDepends::DEPENDS_KEY] = 
                    (isset($aAssetNew[Worker\WorkerDepends::DEPENDS_KEY]))
                    ? $aAssetNew[Worker\WorkerDepends::DEPENDS_KEY] 
                    : [];
            
            $aAssets[$sNameNew] = $aAssetNew;
        }
        
        
    }

}
