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

namespace Intacct\Functions\OrderEntry;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

abstract class AbstractFulfillmentStatus extends AbstractFunction
{
    /** @var string */
    protected $deliveryStatus;

    /** @var \DateTime */
    protected $deliveryDate;

    /** @var string */
    protected $deferralStatus;

    /**
     * @return string
     */
    public function getDeliveryStatus(): string
    {
        return $this->deliveryStatus;
    }

    /**
     * @param string $deliveryStatus
     */
    public function setDeliveryStatus(string $deliveryStatus): void
    {
        $this->deliveryStatus = $deliveryStatus;
    }

    /**
     * @return \DateTime
     */
    public function getDeliveryDate(): \DateTime
    {
        return $this->deliveryDate;
    }

    /**
     * @param \DateTime $deliveryDate
     */
    public function setDeliveryDate(\DateTime $deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @return string
     */
    public function getDeferralStatus(): string
    {
        return $this->deferralStatus;
    }

    /**
     * @param string $deferralStatus
     */
    public function setDeferralStatus(string $deferralStatus): void
    {
        $this->deferralStatus = $deferralStatus;
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXmlDetails(XMLWriter &$xml)
    {
        if (isset($this->deliveryStatus)) {
            $xml->writeElement('deliverystatus', $this->deliveryStatus);
        }

        if (isset($this->deliveryDate)) {
            $xml->startElement('deliverydate');
            $xml->writeDateSplitElements($this->deliveryDate, false);
            $xml->endElement();
        }

        if (isset($this->deferralStatus)) {
            $xml->writeElement('deferralstatus', $this->deferralStatus);
        }
    }
}