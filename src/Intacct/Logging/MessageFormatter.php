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

namespace Intacct\Logging;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class MessageFormatter extends \GuzzleHttp\MessageFormatter
{

    const CLF = "{hostname} {req_header_User-Agent} - [{date_common_log}] \"{method} {target} HTTP/{version}\" {code} {res_header_Content-Length}";
    const DEBUG = ">>>>>>>>\n{request}\n<<<<<<<<\n{response}\n--------\n{error}";
    const SHORT = '[{ts}] "{method} {target} HTTP/{version}" {code}';

    /**
     * Formats log messages using variable substitutions for requests, responses,
     * and other transactional data.
     *
     * @param string $template The following variable substitutions are supported:
     * - `{request}`: Full HTTP request message
     * - `{response}`: Full HTTP response message
     * - `{ts}`: ISO 8601 date in GMT
     * - `{date_iso_8601}`: ISO 8601 date in GMT
     * - `{date_common_log}`: Apache common log date using the configured timezone.
     * - `{host}`: Host of the request
     * - `{method}`: Method of the request
     * - `{uri}`: URI of the request
     * - `{host}`: Host of the request
     * - `{version}`: Protocol version
     * - `{target}`: Request target of the request (path + query + fragment)
     * - `{hostname}`: Hostname of the machine that sent the request
     * - `{code}`: Status code of the response (if available)
     * - `{phrase}`: Reason phrase of the response  (if available)
     * - `{error}`: Any error messages (if available)
     * - `{req_header_*}`: Replace `*` with the lowercased name of a request header to add to the message
     * - `{res_header_*}`: Replace `*` with the lowercased name of a response header to add to the message
     * - `{req_headers}`: Request headers
     * - `{res_headers}`: Response headers
     * - `{req_body}`: Request body
     * - `{res_body}`: Response body
     */
    public function __construct($template = self::DEBUG)
    {
        parent::__construct($template);
    }

    /**
     * @inheritdoc
     */
    public function format(
        RequestInterface $request,
        ?ResponseInterface $response = null,
        ?\Throwable $error = null
    ): string {
        $message = parent::format($request, $response, $error);

        $replacement = '$1REDACTED$3';

        $patterns = [];
        $replacements = [];

        $patterns[] = '/(<password[^>]*>)(.*?)(<\/password>)/i';
        $replacements[] = $replacement;

        $patterns[] = '/(<sessionid[^>]*>)(.*?)(<\/sessionid>)/i';
        $replacements[] = $replacement;

        $patterns[] = '/(<accountnumber[^>]*>)(.*?)(<\/accountnumber>)/i';
        $replacements[] = $replacement;

        $patterns[] = '/(<cardnum[^>]*>)(.*?)(<\/cardnum>)/i';
        $replacements[] = $replacement;

        $patterns[] = '/(<ssn[^>]*>)(.*?)(<\/ssn>)/i';
        $replacements[] = $replacement;

        $patterns[] = '/(<achaccountnumber[^>]*>)(.*?)(<\/achaccountnumber>)/i';
        $replacements[] = $replacement;

        $patterns[] = '/(<wireaccountnumber[^>]*>)(.*?)(<\/wireaccountnumber>)/i';
        $replacements[] = $replacement;

        $patterns[] = '/(<taxid[^>]*>)(.*?)(<\/taxid>)/i';
        $replacements[] = $replacement;

        return preg_replace(
            $patterns,
            $replacements,
            $message
        );
    }
}
