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

namespace Intacct\PlatformServices;

use Intacct\IntacctClientInterface;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;
use ArrayIterator;

interface CustomObjectTraitInterface
{
    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - page_size: (int, default=int(1000)
     * - return_format: (string, default=string(3) "xml")
     * - view: (string, required)
     *
     * @param array $params
     * @param IntacctClientInterface $client
     * @return Result
     * @throws ResultException
     */
    function readView(array $params, IntacctClientInterface &$client);

    /**
     *
     * @param array $params
     * @param IntacctClientInterface $client
     * @return ArrayIterator
     * @throws ResultException
     */
    public function getViewRecords(array $params, IntacctClientInterface &$client);

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - fields: (array)
     * - keys: (array)
     * - object: (string, required)
     * - relation: (string, required)
     * - return_format: (string, default=string(3) "xml")
     *
     * @param array $params
     * @param IntacctClientInterface $client
     * @return Result
     * @throws ResultException
     */
    public function readRelatedObjects(array $params, IntacctClientInterface &$client);
}