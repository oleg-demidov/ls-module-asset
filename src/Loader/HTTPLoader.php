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
 * Description of HTTPLoader
 *
 * @author oleg
 */
class HTTPLoader implements LoaderInterface{
    
    use LoaderTrait;

    public function __construct(string $sPath) {
        if (0 === strpos($sPath, '//')) {
            $sPath = 'http:'.$sPath;
        } elseif (false === strpos($sPath, '://')) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid URL.', $sPath));
        }
        
        $this->sPath = $sPath;
    }
    
    public function getLastModified() {
        
    }
    
    public function load() {
        $content = @file_get_contents($this->sPath);

        if (false === $content) {
            throw new \RuntimeException(sprintf('Unable to load asset from URL "%s"', $this->sPath));
        }

        return $content;
    }


}
