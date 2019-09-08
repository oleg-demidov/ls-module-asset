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

namespace LS\Module\Asset\Loader;

/**
 * Description of LoaderInterface
 *
 * @author oleg
 */
interface LoaderInterface {
    
    /**
     * 
     */
    public function load(\LS\Module\Asset\Asset\Asset $asset);
    
    /**
     * 
     * @param string $sSourcePath
     */
    public function setSourcePath(string $sSourcePath);
    
    
    public function getSourcePath();
    
    public function getLastModified();
    
    public function getResultPath(string $sDir, string $sTargetPath);
    
    /**
     * Обработать параметры ресурса зависимые от зарузчика
     */
    public function prepareParams(array &$aParams);
   
}
