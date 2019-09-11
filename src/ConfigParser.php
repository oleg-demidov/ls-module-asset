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

use LS\Module\Asset\FilterManager;
use LS\Module\Asset\Asset\Asset;
use LS\Module\Asset\Loader\HttpLoader;
use LS\Module\Asset\Loader\LoaderInterface;
use LS\Module\Asset\ParserException;
use OutOfBoundsException;

/**
 * Description of ConfigParser
 *
 * @author oleg
 */
class ConfigParser {
    
    protected $filters;
    
    private $aAssetDefault = [
        'file' =>  '',
        'filters' => [],
        'loader' => Loader\FileLoader::class,
        'remote' => false,
        'merge' => true,
        'public' => true,
        'attr' => [],
        'depends' => []
    ];

    public function __construct(FilterManager $filters = null, array $aAssetDefault = []) {
        $this->filters = $filters;
        
        $this->aAssetDefault = array_merge_recursive( $this->aAssetDefault, $aAssetDefault);
    }
    
    public function parse($aConfig) {        
        
        $assetManager = new AssetManager();
            
        foreach ($aConfig as $sType => $aAssets) { 

            $this->normalizeAssetConfig($aAssets, $this->aAssetDefault);            
            
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
            if(filter_var($aAsset['file'], FILTER_SANITIZE_URL)){
                return new HttpLoader($aAsset['file']);
            }
        }
                        
        if(!class_exists($aAsset['loader'])){
            throw new OutOfBoundsException("Class loader {$aAsset['loader']} not found");
        }

        return new $aAsset['loader']($aAsset['file']);
    }
    
    /**
     * Принимает список ресурсов в виде конфига
     * Изменяет его в удобный для преобразования в ресурсы массив
     * 
     * @param array $aAssets
     */
    public static function normalizeAssetConfig(array &$aAssets, array $aAssetDefault){
                
        foreach ($aAssets as $sName => $mAsset) {
            $aAssetNew = $aAssetDefault;
            $sNameNew = $sName;

            if(is_int($sName)){
                $sNameNew = preg_replace('/\..+$/i', '', basename($mAsset));
            }

            if(is_string($mAsset)){
                $aAssetNew['file'] =  $mAsset;
            }

            if(is_array($mAsset)){                
                $aAssetNew = array_merge($aAssetNew, $mAsset);
            }

            unset($aAssets[$sName]);            
            
            $aAssets[$sNameNew] = $aAssetNew;
        }
        
        
    }

}
