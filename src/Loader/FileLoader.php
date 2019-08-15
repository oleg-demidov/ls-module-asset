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
use LS\Module\Asset\Loader\LoaderInterface;

/**
 * Description of FileLoader
 *
 * @author oleg
 */
class FileLoader implements LoaderInterface{
    
    protected $sPath;

    public function __construct(string $sPath) {
        $this->sPath = $sPath;
    }

    public function load() {
        return file_get_contents($this->sPath);
    }

    public function setPath(string $sPath) {
        $this->sPath = $sPath;
    }

}
