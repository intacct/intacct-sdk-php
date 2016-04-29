<?php

/*
 * Copyright 2016 Intacct Corporation.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"). You may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

namespace Intacct;

use Intacct\Applications\CompanyInterface;
use Intacct\Applications\GeneralLedgerInterface;
use Intacct\Applications\PlatformServicesInterface;
use Intacct\Applications\ReportingInterface;
use Intacct\Xml\Response\Operation\Result;

interface IntacctClientInterface
{
    /**
     * @return CompanyInterface;
     */
    public function getCompany();

    /**
     * @return GeneralLedgerInterface;
     */
    public function getGeneralLedger();

    /**
     * @return PlatformServicesInterface;
     */
    public function getPlatformServices();

    /**
     * @return ReportingInterface;
     */
    public function getReporting();

    /**
     * @return array
     */
    public function getSessionConfig();

    /**
     * @return array
     */
    public function getLastExecution();

    /**
     * @param array $params
     * @return Result
     */
    public function create(array $params);
}