<?php

/**
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

namespace Intacct\Logging;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class MessageFormatter extends \GuzzleHttp\MessageFormatter
{

    /**
     * Initializes the class with the given parameters.
     *
     * Formats log messages using variable substitutions for requests, responses,
     * and other transactional data.
     *
     * The following variable substitutions are supported:
     *
     * - `{request}` Full HTTP request message
     * - `{response}` Full HTTP response message
     * - `{ts}` ISO 8601 date in GMT
     * - `{date_iso_8601}` ISO 8601 date in GMT
     * - `{date_common_log}` Apache common log date using the configured timezone.
     * - `{host}` Host of the request
     * - `{method}` Method of the request
     * - `{uri}` URI of the request
     * - `{host}` Host of the request
     * - `{version}` Protocol version
     * - `{target}` Request target of the request (path + query + fragment)
     * - `{hostname}` Hostname of the machine that sent the request
     * - `{code}` Status code of the response (if available)
     * - `{phrase}` Reason phrase of the response  (if available)
     * - `{error}` Any error messages (if available)
     * - `{req_header_*}` Replace `*` with the lowercased name of a request header to add to the message
     * - `{res_header_*}` Replace `*` with the lowercased name of a response header to add to the message
     * - `{req_headers}` Request headers
     * - `{res_headers}` Response headers
     * - `{req_body}` Request body
     * - `{res_body}` Response body
     *
     * @param string $template Log message template
     */
    public function __construct($template = self::CLF)
    {
        parent::__construct($template);
    }

    /**
     * Returns a formatted message string.
     *
     * @param RequestInterface $request Request that was sent
     * @param ResponseInterface $response Response that was received
     * @param \Exception $error Exception that was received
     *
     * @return string
     */
    public function format(
        RequestInterface $request,
        ResponseInterface $response = null,
        \Exception $error = null
    ) {
        $message = parent::format($request, $response, $error);

        return preg_replace(
            '#<(password)(?:[^>]+)?>.*?</\1>#s',
            '<password>REDACTED</password>',
            $message
        );
    }
}
