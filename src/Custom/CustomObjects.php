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

namespace Intacct\Custom;

use Intacct\CustomObjectTrait;
use Intacct\IntacctClient;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;

class CustomObjects
{
    use CustomObjectTrait;

    private $client;

    /**
     * CustomObjects constructor.
     * @param IntacctClient $client
     */
    public function __construct(IntacctClient &$client)
    {
        $this->client = $client;
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - records: (array, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function create(array $params)
    {
        // Validation here...
        return $this->createObject($params, $this->client);
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - records: (array, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function update(array $params)
    {
        return $this->updateObject($params, $this->client);
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - keys: (array, required)
     * - object: (string, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function delete(array $params)
    {
        return $this->deleteObject($params, $this->client);
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - doc_par_id: (string)
     * - fields: (array)
     * - max_total_count: (int, default=int(100000))
     * - object: (string, required)
     * - page_size: (int, default=int(1000)
     * - query: (string)
     * - return_format: (string, default=string(3) "xml")
     *
     * @param array $params
     * @return \ArrayIterator
     * @throws ResultException
     */
    public function readAll(array $params)
    {
        //TODO: To be tested...
        return $this->getViewRecords($params, $this->client);
    }

    /**
     * @param array $params
     * @return Result
     */
    public function readRelated(array $params)
    {
        return $this->readRelatedObjects($params, $this->client);
    }
}