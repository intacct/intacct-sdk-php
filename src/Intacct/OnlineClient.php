<?php

/**
 * Copyright 2017 Intacct Corporation.
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
use Intacct\Xml\RequestHandler;

class OnlineClient extends AbstractClient
{

    /**
     * @param FunctionInterface[] $content
     * @param RequestConfig $requestConfig
     * @return OnlineResponse
     */
    public function execute(array $content, RequestConfig $requestConfig = null)
    {
        if (!$requestConfig) {
            $requestConfig = new RequestConfig();
        }

        $handler = new RequestHandler($this->getConfig(), $requestConfig);

        return $handler->executeOnline($content);
    }
}
