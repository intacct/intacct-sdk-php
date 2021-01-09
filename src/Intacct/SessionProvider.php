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

use Intacct\Credentials\SenderCredentials;
use Intacct\Credentials\SessionCredentials;
use Intacct\Functions\Company\ApiSessionCreate;

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

        $apiFunction = new ApiSessionCreate();

        if ($config->getSessionId() && $config->getEntityId() !== null) {
            $apiFunction->setEntityId($config->getEntityId());
        }

        $client = new OnlineClient($config);
        $response = $client->execute($apiFunction, $requestConfig);

        $authentication = $response->getAuthentication();
        $result = $response->getResult();

        $result->ensureStatusSuccess(); // throw any result errors

        $data = $result->getData();
        $api = $data[0];

        $config->setSessionId((string)$api->{'sessionid'});
        $config->setEndpointUrl((string)$api->{'endpoint'});
        $config->setEntityId((string)$api->{'locationid'});

        $config->setCompanyId((string)$authentication->getCompanyId());
        $config->setUserId((string)$authentication->getUserId());
        $config->setSessionTimeout((string)$authentication->getSessionTimeout());
        $config->setSessionTimestamp((string)$authentication->getSessionTimestamp());

        $config->setCredentials(new SessionCredentials($config, new SenderCredentials($config)));

        return $config;
    }
}
