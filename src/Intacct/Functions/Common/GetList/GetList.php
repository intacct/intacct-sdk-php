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

namespace Intacct\Functions\Common\GetList;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class GetList extends AbstractFunction
{

    /** @var string */
    protected $objectName;

    /** @var int */
    protected $maxTotalCount;

    /** @var int */
    protected $startAtCount;

    /** @var bool */
    protected $showPrivate = false;

    /** @var SortField[] */
    protected $sortFields;

    /** @var array */
    protected $returnFields;

    /** @var FilterInterface[] */
    protected $filters;

    /** @var AdditionalParameter[] */
    protected $additionalParameters;

    /**
     * @return string
     */
    public function getObjectName()
    {
        return $this->objectName;
    }

    /**
     * @param string $objectName
     */
    public function setObjectName($objectName)
    {
        $this->objectName = $objectName;
    }

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
     * @return int
     */
    public function getStartAtCount()
    {
        return $this->startAtCount;
    }

    /**
     * Set start at count, zero-based
     *
     * @param int $startAtCount
     */
    public function setStartAtCount($startAtCount)
    {
        $this->startAtCount = $startAtCount;
    }

    /**
     * @return boolean
     */
    public function isShowPrivate()
    {
        return $this->showPrivate;
    }

    /**
     * @param boolean $showPrivate
     */
    public function setShowPrivate($showPrivate)
    {
        $this->showPrivate = $showPrivate;
    }

    /**
     * @return SortField[]
     */
    public function getSortFields()
    {
        return $this->sortFields;
    }

    /**
     * @param SortField[] $sortFields
     */
    public function setSortFields($sortFields)
    {
        $this->sortFields = $sortFields;
    }

    /**
     * @return array
     */
    public function getReturnFields()
    {
        return $this->returnFields;
    }

    /**
     * @param array $returnFields
     */
    public function setReturnFields(array $returnFields)
    {
        $this->returnFields = $returnFields;
    }

    /**
     * @return FilterInterface[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param FilterInterface[] $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return AdditionalParameter[]
     */
    public function getAdditionalParameters()
    {
        return $this->additionalParameters;
    }

    /**
     * @param AdditionalParameter[] $additionalParameters
     */
    public function setAdditionalParameters($additionalParameters)
    {
        $this->additionalParameters = $additionalParameters;
    }

    /**
     * Write the function block XML
     *
     * @param XMLWriter $xml
     * @throw InvalidArgumentException
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('get_list');
        if (!$this->getObjectName()) {
            throw new InvalidArgumentException('Object Name is required for get_list');
        }
        $xml->writeAttribute('object', $this->getObjectName(), true);
        if ($this->getMaxTotalCount() > 0) {
            $xml->writeAttribute('maxitems', $this->getMaxTotalCount());
        }
        $xml->writeAttribute('showprivate', $this->isShowPrivate());

        if (count($this->getFilters()) > 0) {
            $xml->startElement('filter');
            foreach ($this->getFilters() as $filter) {
                $filter->writeXml($xml);
            }
            $xml->endElement(); //filter
        }

        if (count($this->getSortFields()) > 0) {
            $xml->startElement('sorts');
            foreach ($this->getSortFields() as $sortField) {
                $sortField->writeXml($xml);
            }
            $xml->endElement(); //sorts
        }

        if (count($this->getReturnFields()) > 0) {
            $xml->startElement('fields');
            foreach ($this->getReturnFields() as $returnField) {
                $xml->writeElement('field', $returnField);
            }
            $xml->endElement(); //fields
        }

        if (count($this->getAdditionalParameters()) > 0) {
            $xml->startElement('additional_parameters');
            foreach ($this->getAdditionalParameters() as $additionalParameter) {
                $additionalParameter->writeXml($xml);
            }
            $xml->endElement(); //additional_parameters
        }

        $xml->endElement(); //get_list

        $xml->endElement(); //function
    }
}
