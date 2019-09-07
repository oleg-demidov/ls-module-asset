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

namespace LS\Module\Asset\Worker;

/**
 * Description of WorkerTargetWrite
 *
 * @author oleg
 */
class WorkerTargetPath implements WorkerInterfase{

    public function work(\LS\Module\Asset\AssetManager $workingAssets, \LS\Module\Asset\AssetFactory $factory) {
        
        foreach ($workingAssets->getNames() as $name) {
            $asset = $workingAssets->get($name);
            /*
             * Получаем расширение
             */
            preg_match('/.+\.([\w]{1,5})([^\.]+)?$/', $asset->getSourcePath(), $aMatches);
            /*
             * Коли нет берем тип в качестве расширения
             */
            $sExtention =isset($aMatches[1]) ? $aMatches[1] : $asset->getType();
            
            $key = $factory->generateKey($asset);
            
            $asset->setTargetPath(
                $asset->getType() . '/' . 
                $key .
                $name . '.' . 
                $sExtention
            );
        }
        
        return $workingAssets;
    }

}
