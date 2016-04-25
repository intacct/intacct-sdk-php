<?php
/**
 * Created by PhpStorm.
 * User: cho
 * Date: 4/25/2016
 * Time: 10:38 AM
 */

namespace Intacct\Company;

use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;

interface UserInterface
{
    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - user_id: (string, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function getUserPermissions(array $params);
}