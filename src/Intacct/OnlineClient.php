<?php

/**
 * Copyright 2021 Sage Intacct, Inc.
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

use Intacct\Functions\FunctionInterface;
use Intacct\Xml\OnlineResponse;

class OnlineClient extends AbstractClient
{

    /**
     * Execute one Sage Intacct API function
     *
     * @param FunctionInterface $function
     * @param RequestConfig $requestConfig
     * @return OnlineResponse
     */
    public function execute(FunctionInterface $function, RequestConfig $requestConfig = null): OnlineResponse
    {
        $response = $this->executeOnlineRequest([ $function ], $requestConfig);

        $response->getResult()->ensureStatusSuccess();

        return $response;
    }

    /**
     * Execute multiple Sage Intacct API functions
     *
     * @param FunctionInterface[] $functions
     * @param RequestConfig $requestConfig
     * @return OnlineResponse
     */
    public function executeBatch(array $functions, RequestConfig $requestConfig = null): OnlineResponse
    {
        $response = $this->executeOnlineRequest($functions, $requestConfig);

        if ($requestConfig->isTransaction()) {
            // If operation transaction=true, loop through to the results and
            // throw exception when status=failure instead of status=aborted
            foreach ($response->getResults() as $result) {
                $result->ensureStatusNotFailure();
            }
        }

        return $response;
    }
}
