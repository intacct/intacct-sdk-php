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

use Intacct\Xml\RequestHandler;
use Intacct\Xml\Request\Operation\Content;
use Intacct\Xml\Request\Operation\Content\Create;
use Intacct\Xml\Request\Operation\Content\Update;
use Intacct\Xml\Request\Operation\Content\Delete;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;
use Intacct\Xml\Request\Operation\Content\Inspect;

trait IntacctObjectTrait
{

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - records: (array, required)
     *
     * @param array $params
     * @param IntacctClient $client
     * @return Result
     * @throws ResultException
     */
    protected function createObject(array $params, IntacctClient &$client)
    {
        $session = $client->getSessionConfig();
        $config = array_merge($session, $params);

        $content = new Content([
            new Create($params),
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $content);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to create records', $result->getErrors()
            );
        }

        return $result;
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - records: (array, required)
     *
     * @param array $params
     * @param IntacctClient $client
     * @return Result
     * @throws ResultException
     */
    protected function updateObject(array $params, IntacctClient &$client)
    {
        $session = $client->getSessionConfig();
        $config = array_merge($session, $params);

        $content = new Content([
            new Update($params),
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $content);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to update records', $result->getErrors()
            );
        }

        return $result;
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - keys: (array, required)
     * - object: (string, required)
     *
     * @param array $params
     * @param IntacctClient $client
     * @return Result
     * @throws ResultException
     */
    protected function deleteObject(array $params, IntacctClient &$client)
    {
        $session = $client->getSessionConfig();
        $config = array_merge($session, $params);

        $content = new Content([
            new Delete($params),
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $content);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to delete records', $result->getErrors()
            );
        }

        return $result;
    }

    /**
     * Accepts the following options:
     *
     * - control_id: (string)
     * - object: (string)
     * - show_detail: (bool, default=bool(false))
     *
     * @param array $params
     * @param IntacctClient $client
     * @return Result
     * @throws ResultException
     */
    protected function inspectObject(array $params, IntacctClient &$client)
    {
        $session = $client->getSessionConfig();
        $config = array_merge($session, $params);

        $content = new Content([
            new Inspect([$params])
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $content);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to inspect an object', $result->getErrors()
            );
        }

        return $result;
    }

}