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

namespace Intacct\Company;

use Intacct\StandardObjectInterface;
use Intacct\IntacctClientInterface;
use Intacct\ObjectTrait;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;

/**
 * Class ClassObj
 * @package Intacct\Company
 * @implements StandardObjectInterface
 */
class ClassObj implements StandardObjectInterface
{

    use ObjectTrait;

    /**
     *
     * @var IntacctClientInterface
     */
    private $client;

    /**
     * 
     * @param IntacctClientInterface $client
     */
    public function __construct(IntacctClientInterface &$client)
    {
        $this->client = $client;
    }

    private function addObjectParam(array $params)
    {
        return array_merge($params, ["object" => "CLASS"]); // Add the object id CLASS for this standard object
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
        return $this->createRecords($params, $this->client);
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
        return $this->updateRecords($params, $this->client);
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - keys: (array, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function delete(array $params)
    {
        $allParams = $this->addObjectParam($params);

        return $this->deleteRecords($allParams, $this->client);
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - doc_par_id: (string)
     * - fields: (array)
     * - max_total_count: (int, default=int(100000))
     * - page_size: (int, default=int(1000)
     * - query: (string)
     * - return_format: (string, default=string(3) "xml")
     *
     * @param array $params
     * @return \ArrayIterator
     * @throws ResultException
     */
    public function readAllByQuery(array $params)
    {
        $allParams = $this->addObjectParam($params);

        return $this->readAllObjectsByQuery($allParams, $this->client);
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - show_detail: (bool, default=bool(false))
     *
     * @param array $params
     * @return Result
     */
    public function inspect(array $params)
    {
        $allParams = $this->addObjectParam($params);

        return $this->inspectObject($allParams, $this->client);
    }
}