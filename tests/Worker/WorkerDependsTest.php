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
namespace PHPUnit\Framework\TestCase;

use ConfigParserTest;
use LS\Module\Asset\Worker\WorkerDepends;
use PHPUnit\Framework\TestCase;

/**
 * Description of WorkerDependsTest
 *
 * @author oleg
 */
class WorkerDependsTest extends TestCase{
    
    public function testWork() {
        
        $assetManager = (new ConfigParserTest())->getAssetManager();   
                
        $workerDepends = new WorkerDepends($assetManager);
        
        $this->assertTrue($assetManager->getNames() === [
            'assetJsHTTP',
            'assetJsLocal',
            'assetJsRemote']);
        
    }
}
