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

namespace Intacct\Logging;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @inheritdoc
 */
final class MessageFormatter extends \GuzzleHttp\MessageFormatter
{

    /** @var string */
    const REPLACEMENT = '$1REDACTED$3';

    /**
     * @inheritdoc
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
        ResponseInterface $response = null,
        \Exception $error = null
    ) {
        $message = parent::format($request, $response, $error);

        $patterns = [];
        $replacements = [];

        $patterns[] = '/(<password[^>]*>)(.*?)(<\/password>)/i';
        $replacements[] = static::REPLACEMENT;

        $patterns[] = '/(<sessionid[^>]*>)(.*?)(<\/sessionid>)/i';
        $replacements[] = static::REPLACEMENT;

        $patterns[] = '/(<accountnumber[^>]*>)(.*?)(<\/accountnumber>)/i';
        $replacements[] = static::REPLACEMENT;

        $patterns[] = '/(<cardnum[^>]*>)(.*?)(<\/cardnum>)/i';
        $replacements[] = static::REPLACEMENT;

        $patterns[] = '/(<ssn[^>]*>)(.*?)(<\/ssn>)/i';
        $replacements[] = static::REPLACEMENT;

        $patterns[] = '/(<achaccountnumber[^>]*>)(.*?)(<\/achaccountnumber>)/i';
        $replacements[] = static::REPLACEMENT;

        $patterns[] = '/(<wireaccountnumber[^>]*>)(.*?)(<\/wireaccountnumber>)/i';
        $replacements[] = static::REPLACEMENT;

        $patterns[] = '/(<taxid[^>]*>)(.*?)(<\/taxid>)/i';
        $replacements[] = static::REPLACEMENT;

        return preg_replace(
            $patterns,
            $replacements,
            $message
        );
    }
}
