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

/**
 * Description of PublicFolderController
 *
 * @author oleg
 */
class PublicDirController {
    
    protected $sUrl;

    public function __construct(string $sUrl) {
        $this->sUrl = $sUrl;
    }
    
    public function add($directory) {
        
    }
    
    public function run() {
        echo $this->sUrl;
    }
}
