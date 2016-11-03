<?php

/**
 * Copyright 2016 Intacct Corporation.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License"). You may not
 *  use this file except in compliance with the License. You may obtain a copy
 *  of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "LICENSE" file accompanying this file. This file is distributed on
 * an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 */

namespace Intacct;

use Intacct\Exception\ResultException;
use Intacct\Functions\Common\ReadByQuery;
use Intacct\Functions\Common\ReadMore;
use ArrayIterator;

class QueryClient extends AbstractClient
{

    /** @var int */
    const DEFAULT_MAX_TOTAL_COUNT = 100000;

    /** @var int */
    protected $maxTotalCount;

    /**
     * @return int
     */
    public function getMaxTotalCount()
    {
        return $this->maxTotalCount;
    }

    /**
     * @param int $maxTotalCount
     */
    public function setMaxTotalCount($maxTotalCount)
    {
        $this->maxTotalCount = $maxTotalCount;
    }

    /**
     * @param ReadByQuery $query
     * @param int $maxTotalCount
     * @param array $params Overriding params
     *
     * @return ArrayIterator
     * @throws ResultException
     */
    public function executeQuery(ReadByQuery $query, $maxTotalCount = self::DEFAULT_MAX_TOTAL_COUNT, array $params = [])
    {
        $this->setMaxTotalCount($maxTotalCount);

        $content = new Content([
            $query,
        ]);
        $response = parent::execute($content, false, null, false, $params);
        $result = $response->getOperation()->getResult();

        if ($result->getStatus() !== 'success') {
            throw new ResultException(
                'An error occurred trying to get query records',
                $result->getErrors()
            );
        }

        if ($result->getTotalCount() > $this->getMaxTotalCount()) {
            throw new ResultException(
                'Query result totalcount of ' . $result->getTotalCount() .
                ' exceeds max totalcount parameter of ' . $this->getMaxTotalCount()
            );
        }

        $records = new ArrayIterator();

        foreach ($result->getDataArray() as $record) {
            $records->append($record);
        }

        while ($result->getNumRemaining() > 0) {
            // Do readMore's with the resultId until number remaining is zero
            $readMore = new ReadMore();
            $readMore->setResultId($result->getResultId());

            $content = new Content([
                $readMore,
            ]);
            $response = parent::execute($content, false, null, false, $params);
            $result = $response->getOperation()->getResult();

            if ($result->getStatus() !== 'success') {
                throw new ResultException(
                    'An error occurred trying to query subsequent records',
                    $result->getErrors()
                );
            }

            foreach ($result->getDataArray() as $record) {
                $records->append($record);
            }
        }

        $records->rewind();

        return $records;
    }
}
