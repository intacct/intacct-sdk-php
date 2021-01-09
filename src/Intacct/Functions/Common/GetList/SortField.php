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

namespace Intacct\Functions\Common\GetList;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class SortField
{

    /** @var string */
    const ORDER_BY_ASC = 'asc';

    /** @var string */
    const ORDER_BY_DESC = 'desc';

    /** @var string */
    protected $fieldName = '';

    /** @var string */
    protected $orderBy = self::ORDER_BY_ASC;

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * @param string $fieldName
     */
    public function setFieldName(string $fieldName)
    {
        $this->fieldName = $fieldName;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy)
    {
        $orderBys = [
            static::ORDER_BY_ASC,
            static::ORDER_BY_DESC,
        ];

        if (!in_array($orderBy, $orderBys)) {
            throw new InvalidArgumentException('Order By must be either "asc" or "desc"');
        }
        $this->orderBy = $orderBy;
    }

    /**
     * Write the sortfield block XML
     *
     * @param XMLWriter $xml
     */
    public function writeXml(XMLWriter &$xml)
    {
        $xml->startElement('sortfield');
        $xml->writeAttribute('order', $this->getOrderBy());

        $xml->text($this->getFieldName());

        $xml->endElement(); //sortfield
    }
}
