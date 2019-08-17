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
use \Assetic\Util\VarUtils;

/**
 * Description of FileLoader
 *
 * @author oleg
 */
class FileLoader implements LoaderInterface{
    
    use LoaderTrait;
    
    public function __construct(string $sSourcePath) {
        $this->sSourcePath = $sSourcePath;
    }

    public function load() {

        if (!is_file($this->sSourcePath)) {
            throw new \RuntimeException(sprintf('The source file "%s" does not exist.', $this->sSourcePath));
        }
                
        return file_get_contents($this->sSourcePath);
    }

    public function getLastModified() {

        if (!is_file($this->sSourcePath)) {
            throw new \RuntimeException(sprintf('The source file "%s" does not exist.', $this->sSourcePath));
        }

        return filemtime($this->sSourcePath);
    }


}
