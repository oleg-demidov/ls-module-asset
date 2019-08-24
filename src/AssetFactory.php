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
use LS\Module\Asset\Worker\WorkerInterfase;
use OutOfBoundsException;
use OutOfRangeException;
use ReflectionClass;

/**
 * Description of ModuleAsset
 *
 * @author oleg
 */
class AssetFactory {
    
    protected $filters;
    
    protected $aParams;
    
    /**
     * @var AssetManager
     */
    protected $assets;
    
    protected $workers = [];

    public function __construct(array $aParams = []) {
        
        $this->aParams = $aParams;
        
    }
        
    public function setFilterManager(FilterManager $filters) {
        $this->filters = $filters;
    }
    
    public function getFilterManager() {
        return $this->filters;
    }
    
    
    public function setAssetManager(AssetManager $assets) {
        $this->assets = $assets;
    }
    
    public function createAssetType(string $sType) {
        
        $aSortAssets = $this->sortByTypes($this->assets);
        
        if(!isset($aSortAssets[$sType])){
            throw new \OutOfRangeException("Type {$sType} not isset in assets types");
        }
        
        return $this->createAsset($aSortAssets[$sType]->getNames());
        
    }
    
    public function createAssetSorted() {
        $aSortAssets = $this->sortByTypes($this->assets);
        
        $aResult = [];
        
        foreach ($aSortAssets as $sType => $assets) {            
            $aResult[$sType] = $this->createAsset($aSortAssets[$sType]->getNames());
        }
        
        return $aResult;
    }
       
    protected function sortByTypes(AssetManager $assets) {
        $aSort = [];
        
        foreach ($assets->getNames() as $sName) {
            $asset = $assets->get($sName);
            
            if(!isset($aSort[$asset->getType()])){
                $aSort[$asset->getType()] = new AssetManager();
            }
            
            $aSort[$asset->getType()]->set($sName, $asset);
        }
        
        return $aSort;
    }
    /**
     * 
     * @param array $aInputs
     * @return AssetManager
     * @throws OutOfRangeException
     * @throws OutOfBoundsException
     */
    public function createAsset(array $aInputs = []) {
        
        if(!$this->assets){
            throw new OutOfRangeException("Asset manager must be set in factory");
        }
        
        if($aInputs){
            $assetManagerInputs = new AssetManager();
        }else{
            $assetManagerInputs = clone $this->assets;
        }
        
        foreach ($aInputs as $alias) {
            if(!$this->assets->has($alias)){
                throw new OutOfBoundsException("In manager not asset `{$alias}`");
            }
            
            $asset = $this->assets->get($alias);
            
            $assetManagerInputs->set($alias, $asset);
        }
        
        $assetManagerInputs = $this->applyWorkers($assetManagerInputs);
                
        return $assetManagerInputs;
    }
        
    public function get($alias) {
        return $this->assets->get($alias);
    }
    
    public function addWorker(WorkerInterfase $worker) {
        $this->workers[] = $worker;
    }
    
    public function applyWorkers(AssetManager $assetManagerInputs) { 
        
        foreach ($this->workers as $worker) {        
            $assetManagerInputs = $worker->work($assetManagerInputs, $this);
        }
        
        return $assetManagerInputs;        
        
    }
    /**
     * 
     * @return AssetManager
     */
    public function getAssetManager() {
        return $this->assets;
    }
    
    public function getParams() {
        return $this->aParams;
    }
    
    public function generateAssetKey( $factory)
    {
        return substr(sha1(serialize($factory)), 0, 7);
    }

}
