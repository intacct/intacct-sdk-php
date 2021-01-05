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

namespace Intacct\Functions\Common\NewQuery;

use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Common\NewQuery\QueryFilter\FilterInterface;
use Intacct\Functions\Common\NewQuery\QueryOrderBy\OrderInterface;
use Intacct\Functions\Common\NewQuery\QuerySelect\SelectInterface;
use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class Query extends AbstractFunction implements QueryFunctionInterface
{

    /** @var SelectInterface[] */
    private $selectFields;

    /** @var string */
    private $fromObject;

    /** @var string */
    private $docParId;

    /** @var FilterInterface */
    private $filter;

    /** @var OrderInterface[] */
    private $orderBy;

    /** @var bool */
    private $caseInsensitive;

    /** @var bool */
    private $showPrivate;

    /** @var int */
    private $pageSize;

    /** @var int */
    private $offset;

    /**
     * @return SelectInterface[]|null
     */
    public function getSelect() //: ?array
    {
        return $this->selectFields;
    }

    /**
     * @param SelectInterface[] $fields
     */
    public function setSelect(array $fields)
    {
        if (!$fields) {
            throw new InvalidArgumentException(
                'Field name for select cannot be empty or null. Provide Field name for select in array.'
            );
        }

        $this->selectFields = $fields;
    }

    /**
     * @param SelectInterface[] $fields
     * @return QueryFunctionInterface
     */
    public function select(array $fields): QueryFunctionInterface
    {
        $this->setSelect($fields);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrom() //: ?string
    {
        return $this->fromObject;
    }

    /**
     * @param string $objectName
     * @throws InvalidArgumentException
     */
    public function setFrom(string $objectName)
    {
        if ($objectName !== '' && $objectName) {
            $this->fromObject = $objectName;
        } else {
            throw new InvalidArgumentException(
                'Object name for setting from cannot be empty or null. Set object name using from setter.'
            );
        }
    }

    /**
     * @param string $objectName
     * @return QueryFunctionInterface
     */
    public function from(string $objectName): QueryFunctionInterface
    {
        $this->setFrom($objectName);

        return $this;
    }

    /**
     * @param string $docParId
     * @throws InvalidArgumentException
     */
    public function setDocParId($docParId)
    {
        if ($docParId !== '' && $docParId) {
            $this->docParId = $docParId;
        } else {
            throw new InvalidArgumentException(
                'docParId cannot be empty. Set docParId with valid document identifier.'
            );
        }
    }

    /**
     * @return string|null
     */
    public function getDocParId() //: ?string
    {
        return $this->docParId;
    }

    /**
     * @param $docParId
     * @return QueryFunctionInterface
     */
    public function docParId($docParId): QueryFunctionInterface
    {
        $this->setDocParId($docParId);

        return $this;
    }

    /**
     * @return FilterInterface|null
     */
    public function getFilter() //: ?FilterInterface
    {
        return $this->filter;
    }

    /**
     * @param FilterInterface $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @param FilterInterface $filter
     * @return QueryFunctionInterface
     */
    public function filter($filter): QueryFunctionInterface
    {
        $this->setFilter($filter);

        return $this;
    }

    /**
     * @return OrderInterface[]|null
     */
    public function getOrderBy() //: ?array
    {
        return $this->orderBy;
    }

    /**
     * @param OrderInterface[] $orderBy
     */
    public function setOrderBy($orderBy)
    {
        if (!$orderBy) {
            throw new InvalidArgumentException(
                'Field name for orderBy cannot be empty or null. Provide orders for orderBy in array.'
            );
        }

        $this->orderBy = $orderBy;
    }

    /**
     * @param OrderInterface[] $orderBy
     * @return QueryFunctionInterface
     */
    public function orderBy($orderBy): QueryFunctionInterface
    {
        $this->setOrderBy($orderBy);

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isCaseInsensitive() //: ?bool
    {
        return $this->caseInsensitive;
    }

    /**
     * @param bool $caseInsensitive
     */
    public function setCaseInsensitive(bool $caseInsensitive)
    {
        $this->caseInsensitive = $caseInsensitive;
    }

    /**
     * @param bool $caseInsensitive
     * @return QueryFunctionInterface
     */
    public function caseInsensitive(bool $caseInsensitive): QueryFunctionInterface
    {
        $this->setCaseInsensitive($caseInsensitive);

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isShowPrivate() //: ?bool
    {
        return $this->showPrivate;
    }

    /**
     * @param bool $showPrivate
     */
    public function setShowPrivate(bool $showPrivate)
    {
        $this->showPrivate = $showPrivate;
    }

    /**
     * @param bool $showPrivate
     * @return QueryFunctionInterface
     */
    public function showPrivate(bool $showPrivate): QueryFunctionInterface
    {
        $this->setShowPrivate($showPrivate);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPageSize() //: ?int
    {
        return $this->pageSize;
    }

    /**
     * @param int $pageSize
     * @throws InvalidArgumentException
     */
    public function setPageSize(int $pageSize)
    {
        if ($pageSize < 0) {
            throw new InvalidArgumentException('pageSize cannot be negative. Set pageSize greater than zero.');
        }

        $this->pageSize = $pageSize;
    }

    /**
     * @param int $pageSize
     * @return QueryFunctionInterface
     */
    public function pageSize(int $pageSize): QueryFunctionInterface
    {
        $this->setPageSize($pageSize);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOffset() //: ?int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @throws InvalidArgumentException
     */
    public function setOffset(int $offset)
    {
        if ($offset < 0) {
            throw new InvalidArgumentException('offset cannot be negative. Set offset to zero or greater than zero.');
        }

        $this->offset = $offset;
    }

    /**
     * @param int $offset
     * @return QueryFunctionInterface
     */
    public function offset(int $offset): QueryFunctionInterface
    {
        $this->setOffset($offset);

        return $this;
    }

    private function hasOptions()
    {
        return $this->isShowPrivate() || $this->isCaseInsensitive();
    }

    /**
     * @param XMLWriter $xml
     * @throws InvalidArgumentException
     */
    public function writeXML(XMLWriter &$xml)
    {
        $xml->startElement('function');
        $xml->writeAttribute('controlid', $this->getControlId());

        $xml->startElement('query');

        if (!$this->getSelect()) {
            throw new InvalidArgumentException(
                'Select fields are required for query; set through method select setter.'
            );
        }

        $xml->startElement('select');
        foreach ($this->getSelect() as $field) {
            $field->writeXML($xml);
        }
        $xml->endElement(); // select

        if (!$this->getFrom()) {
            throw new InvalidArgumentException('Object Name is required for query; set through method from setter.');
        }

        $xml->writeElement('object', $this->getFrom(), false);

        if ($this->getDocParId()) {
            $xml->writeElement('docparid', $this->getDocParId(), false);
        }

        if ($this->getFilter()) {
            $xml->startElement('filter');

            $this->getFilter()
                ->writeXML($xml);

            $xml->endElement();
        }

        if ($this->getOrderBy()) {
            $xml->startElement('orderby');
            foreach ($this->getOrderBy() as $order) {
                $order->writeXML($xml);
            }
            $xml->endElement(); // orderby
        }

        if ($this->hasOptions()) {
            $xml->startElement('options');

            if ($this->isCaseInsensitive()) {
                $xml->writeElement('caseinsensitive', $this->isCaseInsensitive(), false);
            }
            if ($this->isShowPrivate()) {
                $xml->writeElement('showprivate', $this->isShowPrivate(), false);
            }
            $xml->endElement();
        }

        if ($this->getPageSize()) {
            $xml->writeElement('pagesize', $this->getPageSize(), false);
        }

        if ($this->getOffset()) {
            $xml->writeElement('offset', $this->getOffset(), false);
        }

        $xml->endElement(); //query

        $xml->endElement(); //function
    }
}