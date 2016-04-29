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
use Intacct\Xml\RequestHandler;
use Intacct\Xml\Request\Operation\ContentBlock;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;
use Intacct\Xml\Request\Operation\Content\ReadRelated;
use Intacct\Xml\Request\Operation\Content\ReadView;
use ArrayIterator;
use Intacct\ObjectTrait;


trait CustomObjectTrait
{
    
    use ObjectTrait;

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
    protected function readView(array $params, IntacctClientInterface &$client)
    {
        $session = $client->getSessionConfig();
        $config = array_merge($session, $params);

        $contentBlock = new ContentBlock([
            new ReadView($params),
        ]);

        $requestHandler = new RequestHandler($config);

        $operation = $requestHandler->executeContent($config, $contentBlock);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException('An error occurred trying to read view records', $result->getErrors());
        }

        return $result;
    }

    /**
     *
     * @param array $params
     * @param IntacctClientInterface $client
     * @return ArrayIterator
     * @throws ResultException
     */
    public function getViewRecords(array $params, IntacctClientInterface &$client)
    {
        $defaults = [
            'max_total_count' => self::$MAX_QUERY_TOTAL_COUNT,
        ];
        $config = array_merge($defaults, $params);

        $result = $this->readView($config, $client);

        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to get view records', $result->getErrors()
            );
        }

        $records = new ArrayIterator();
        foreach ($result->getDataArray(true) as $record) {
            $records->append($record);
        }

        $totalCount = (int) strval($result->getData()->attributes()->totalcount);
        if ($totalCount > $config['max_total_count']) {
            throw new ResultException(
                'Query result totalcount exceeds max_total_count parameter of ' . $config['max_total_count']
            );
        }
        $numRemaining = (int) strval($result->getData()->attributes()->numremaining);
        if ($numRemaining > 0) {
            $pages = ceil($numRemaining / $config['page_size']);
            $resultId = $result->getData()->attributes()->resultId;
            $config['result_id'] = $resultId;
            for ($page = 1; $page <= $pages; $page++) {
                $readMore = $this->readMore($config, $client);

                //append the readMore records to the original array
                foreach ($readMore->getDataArray(true) as $record) {
                    $records->append($record);
                }
            }
        }

        return $records;
    }

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
    public function readRelatedObjects(array $params, IntacctClientInterface &$client)
    {
        $session = $client->getSessionConfig();
        $config = array_merge($session, $params);

        $contentBlock = new ContentBlock([
            new ReadRelated($params),
        ]);

        $requestHandler = new RequestHandler($params);

        $operation = $requestHandler->executeContent($config, $contentBlock);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to read related records', $result->getErrors()
            );
        }

        return $result;
    }
}