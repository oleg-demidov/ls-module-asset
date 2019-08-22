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

use Assetic\Filter\FilterInterface;
use Assetic\FilterManager;

/**
 * Description of ModuleAsset
 *
 * @author oleg
 */
class AssetFactory {
    
    protected $filters;
    
    protected $aParams;
    
    protected $assets;
    
    protected $workers = [];

    public function __construct($aParams) {
        $this->aParams = $aParams;
        
    }
        
    public function setFilterManager(FilterManager $filters) {
        $this->filters = $filters;
    }
    
    public function getFilterManager() {
        return $this->filters;
    }
    
    public function setAssetManager(\Assetic\AssetManager $assets) {
        $this->assets = $assets;
    }
    
    public function buildHTML(string $sType) {
                
        return '<script type="'.dirname(__DIR__).'/tests/assets/test.js" src=""></script>'
                . '<script type="https://code.jquery.com/jquery-3.4.1.js" src=""></script>';
    }
    
    public function createAsset(array $aInputs) {
        
        if(!$this->assets){
            throw new \OutOfRangeException("Asset manager must be set in factory");
        }
        
        $assetManagerInputs = new AssetManager();
        
        foreach ($aInputs as $alias) {
            if(!$this->assets->has($alias)){
                throw new \OutOfBoundsException("In manager not asset `{$alias}`");
            }
            
            $assetManagerInputs->set($alias, $this->assets->get($alias));
        }
        
        $assetManagerInputs = $this->applyWorkers($assetManagerInputs);
                
        $assets = new \Assetic\Asset\AssetCollection();
        
        foreach ($assetManagerInputs->getNames() as $alias) {
            $assets->add($assetManagerInputs->get($alias));
        }
        
        return $assets;
    }
    
    public function get($alias) {
        return $this->assets->get($alias);
    }
    
    public function addWorker(Worker\WorkerInterfase $worker) {
        $this->workers[] = $worker;
    }
    
    public function applyWorkers(AssetManager $assetManagerInputs) { 
        
        foreach ($this->workers as $worker) {        
            $assetManagerInputs = $worker->work($assetManagerInputs, $this);
        }
        
        return $assetManagerInputs;        
        
    }
    
    public function getAssetManager() {
        return $this->assets;
    }
}
