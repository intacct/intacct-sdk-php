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

namespace Intacct\Functions\Common\NewQuery\QuerySelect;

class SelectBuilder
{

    /**
     * @var SelectInterface[]
     */
    private $_selects;

    /**
     * @var SelectFunctionFactory
     */
    private $_factory;

    /**
     * SelectBuilder constructor.
     */
    public function __construct()
    {
        $this->_selects = [];
        $this->_factory = new SelectFunctionFactory();
    }

    /**
     * @param string $fieldName
     *
     * @return SelectBuilder
     */
    public function field(string $fieldName): SelectBuilder
    {
        $_currentSelectField = new Field($fieldName);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string[] $fieldNames
     *
     * @return SelectBuilder
     */
    public function fields(array $fieldNames): SelectBuilder
    {
        foreach ($fieldNames as $fieldName) {
            $_currentSelectField = new Field($fieldName);
            $this->_selects[] = $_currentSelectField;
        }

        return $this;
    }

    /**
     * @param string $fieldName
     *
     * @return SelectBuilder
     */
    public function avg(string $fieldName): SelectBuilder
    {
        $_currentSelectField = $this->_factory->create(AbstractSelectFunction::AVERAGE, $fieldName);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string $fieldName
     *
     * @return SelectBuilder
     */
    public function min(string $fieldName): SelectBuilder
    {
        $_currentSelectField = $this->_factory->create(AbstractSelectFunction::MINIMUM, $fieldName);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string $fieldName
     *
     * @return SelectBuilder
     */
    public function max(string $fieldName): SelectBuilder
    {
        $_currentSelectField = $this->_factory->create(AbstractSelectFunction::MAXIMUM, $fieldName);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string $fieldName
     *
     * @return SelectBuilder
     */
    public function count(string $fieldName): SelectBuilder
    {
        $_currentSelectField = $this->_factory->create(AbstractSelectFunction::COUNT, $fieldName);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string $fieldName
     *
     * @return SelectBuilder
     */
    public function sum(string $fieldName): SelectBuilder
    {
        $_currentSelectField = $this->_factory->create(AbstractSelectFunction::SUM, $fieldName);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @return SelectInterface[]
     */
    public function getFields(): array
    {
        return $this->_selects;
    }
}