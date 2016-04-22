<?php
/**
 * Created by PhpStorm.
 * User: cho
 * Date: 4/22/2016
 * Time: 4:12 PM
 */

namespace Intacct\Applications;

use Intacct\PlatformServices\Application;

interface PlatformServicesInterface
{

    /**
     *
     * @return Application
     */
    public function getApplication();
}