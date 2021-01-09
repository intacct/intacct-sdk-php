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

namespace Intacct\Functions\AccountsPayable;

use Intacct\Exception\IntacctException;
use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

abstract class AbstractApPaymentFunction extends AbstractFunction
{
    public const DELETE = 'delete';

    public const DECLINE = 'decline_appaymentrequest';

    public const CONFIRM = 'confirm_appaymentrequest';

    public const APPROVE = 'approve_appaymentrequest';

    public const SEND = 'send_appaymentrequest';

    public const VOID = 'void_appaymentrequest';

    /** @var int */
    protected $recordNo;

    public function __construct(int $recordNo, string $controlId)
    {
        parent::__construct($controlId);
        $this->recordNo = $recordNo;
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml): void
    {
        switch ($this->getFunction()) {
            case self::DELETE:
                $this->writeCrudXml($xml);
                break;
            case self::DECLINE:
            case self::CONFIRM:
            case self::APPROVE:
            case self::SEND:
            case self::VOID:
                $this->writeLegacyXml($xml);
                break;
            default:
                throw new IntacctException('Cannot write XML for ApPaymentFunction ' . $this->getFunction());
        }
    }

    abstract protected function getFunction(): string;

    private function writeCrudXml(XMLWriter &$xml): void
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->controlId, true);

        $xml->startElement($this->getFunction());

        $xml->writeElement('object', 'APPYMT');
        $xml->writeElement('keys', $this->recordNo);

        $xml->endElement(); // delete

        $xml->endElement(); // function
    }

    private function writeLegacyXml(XMLWriter &$xml): void
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->controlId, true);

        $xml->startElement($this->getFunction());

        $xml->startElement('appaymentkeys');

        $xml->writeElement('appaymentkey', $this->recordNo, true);

        $xml->endElement(); // appaymentkeys

        $xml->endElement(); // GetFunction

        $xml->endElement(); // function
    }
}