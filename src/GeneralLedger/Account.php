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

namespace Intacct\GeneralLedger;

use Intacct\IntacctClientInterface;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;
use Intacct\IaObjectTrait;
use Intacct\IaObjectTraitInterface;

class Account implements IaObjectTraitInterface
{

    use IaObjectTrait;

    /**
     *
     * @var IntacctClientInterface
     */
    private $client;

    /**
     * Account constructor
     * 
     * @param IntacctClientInterface $client
     */
    public function __construct(IntacctClientInterface &$client)
    {
        $this->client = $client;
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - add other field keys here
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     * @todo change this to a single record create
     */
    public function create(array $params)
    {
        // TODO Validation here...
        // TODO change this to <create_bill>... <create> is not supported
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
     * - object: (string, required)
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function delete(array $params)
    {
        return $this->deleteRecords($params, $this->client);
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
    public function readAllByQuery(array $params)
    {
        return $this->readAllObjectsByQuery($params, $this->client);
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - doc_par_id: (string)
     * - fields: (array)
     * - keys: (array)
     * - object: (string, required)
     * - return_format: (string, default=string(3) "xml")
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function readById(array $params)
    {
        return $this->readRecordById($params, $this->client);
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - fields: (array)
     * - names: (array)
     * - object: (string, required)
     * - return_format: (string, default=string(3) "xml")
     *
     * @param array $params
     * @return Result
     * @throws ResultException
     */
    public function readByName(array $params)
    {
        return $this->readRecordByName($params, $this->client);
    }
    
}