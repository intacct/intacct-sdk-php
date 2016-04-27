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

namespace Intacct\Reporting;
use Intacct\IntacctClientInterface;
use Intacct\Xml\Request\Operation\ContentBlock;
use Intacct\Xml\Request\Operation\Content\ReadReport;
use Intacct\Xml\RequestHandler;
use Intacct\Xml\Response\Operation\Result;
use Intacct\Xml\Response\Operation\ResultException;
use ArrayIterator;
use Intacct\ObjectTrait;

class CustomReport
{
    
    use ObjectTrait;

    /**
     *
     * @var IntacctClientInterface
     */
    private $client;

    /**
     * Dimensions constructor.
     * @param IntacctClientInterface $client
     */
    public function __construct(IntacctClientInterface &$client)
    {
        $this->client = $client;
    }

    /**
     *
     * @param array $params
     * @param IntacctClientInterface $client
     * @return Result
     * @throws ResultException
     * @todo Finish this function, it's missing stuff and messy
     */
    private function readReport(array $params, IntacctClientInterface &$client)
    {
        $session = $client->getSessionConfig();
        $config = array_merge($session, $params);

        $contentBlock = new ContentBlock([
            new ReadReport($params),
        ]);

        $requestHandler = new RequestHandler($config);

        $operation = $requestHandler->executeContent($config, $contentBlock);

        $result = $operation->getResult();
        if ($result->getStatus() !== 'success') {
            throw new ResultException('An error occurred trying to read report records', $result->getErrors());
        }

        return $result;
    }

    /**
     *
     * @param array $params
     * @param IntacctClientInterface $client
     * @return ArrayIterator
     * @throws ResultException
     * @todo this function is not finished yet to support report runtimes
     */
    public function run(array $params, IntacctClientInterface &$client)
    {
        $defaults = [
            'max_total_count' => self::$MAX_QUERY_TOTAL_COUNT,
        ];
        $config = array_merge($defaults, $params);

        $result = $this->readReport($config, $client);

        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to get report records', $result->getErrors()
            );
        }

        $records = new ArrayIterator();
        //TODO check if readReport nested or not
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
                //TODO check if readReport nested or not
                foreach ($readMore->getDataArray(true) as $record) {
                    $records->append($record);
                }
            }
        }

        return $records;
    }
    
}