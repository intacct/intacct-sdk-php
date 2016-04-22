<?php
/**
 * Created by PhpStorm.
 * User: cho
 * Date: 4/22/2016
 * Time: 4:05 PM
 */

namespace Intacct\Applications;

use Intacct\GeneralLedger\Account;

interface GeneralLedgerInterface
{
    /**
     *
     * @return Account
     */
    public function getAccount();
}