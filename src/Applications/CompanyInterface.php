<?php
/**
 * Created by PhpStorm.
 * User: cho
 * Date: 4/22/2016
 * Time: 3:20 PM
 */

namespace Intacct\Applications;

use Intacct\Company\ClassObj;
use Intacct\Company\User;

interface CompanyInterface
{

    /**
     * @return ClassObj
     */
    public function getClassObj();

    /**
     * @return User
     */
    public function getUser();
    
}