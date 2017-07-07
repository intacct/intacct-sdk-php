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

use Intacct\Credentials\SenderCredentials;
use Intacct\Credentials\SessionCredentials;
use Intacct\Functions\Company\ApiSessionCreate;
use Intacct\Xml\RequestHandler;

class SessionProvider
{

    /**
     * @param ClientConfig $config
     * @return ClientConfig
     */
    public static function factory(ClientConfig $config = null): ClientConfig
    {
        if (!$config) {
            $config = new ClientConfig();
        }

        $requestConfig = new RequestConfig();
        $requestConfig->setControlId('sessionProvider');
        $requestConfig->setNoRetryServerErrorCodes([]); // Retry all 500 level errors

        $handler = new RequestHandler($config, $requestConfig);
        $content = [
            new ApiSessionCreate(),
        ];
        $response = $handler->executeOnline($content);
        $result = $response->getResult();

        $result->ensureStatusSuccess(); // throw any result errors

        $data = $result->getData();
        $api = $data->api;

        $config->setSessionId(strval($api->sessionid));
        $config->setEndpointUrl(strval($api->endpoint));

        $config->setCredentials(new SessionCredentials($config, new SenderCredentials($config)));

        return $config;
    }
}
