<?php

/**
 * Copyright 2020 Sage Intacct, Inc.
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

namespace Intacct\Functions\Common\QuerySelect;

use InvalidArgumentException;

class SelectBuilder
{

    /**
     * @var SelectInterface[]
     */
    private $_selects;

    /**
     * SelectBuilder constructor.
     */
    public function __construct()
    {
        $this->_selects = [];
    }

    /**
     * @param string $value
     *
     * @return SelectBuilder
     */
    public function field(string $value) : SelectBuilder
    {
        if ( ! $value ) {
            throw new InvalidArgumentException('Fields cannot be empty or null. Provide a field for the builder.');
        }
        $_currentSelectField = new Field($value);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string[] $values
     *
     * @return SelectBuilder
     */
    public function fields(array $values) : SelectBuilder
    {
        foreach ( $values as $value ) {
            if ( ! $value ) {
                throw new InvalidArgumentException('Fields cannot be empty or null. Provide a list of fields for the builder.');
            }
            $_currentSelectField = new Field($value);
            $this->_selects[] = $_currentSelectField;
        }

        return $this;
    }

    /**
     * @param string $value
     *
     * @return SelectBuilder
     */
    public function avg(string $value) : SelectBuilder
    {
        if ( ! $value ) {
            throw new InvalidArgumentException('Fields for avg cannot be empty or null. Provide a field for the builder.');
        }
        $_currentSelectField = new Average($value);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return SelectBuilder
     */
    public function min(string $value) : SelectBuilder
    {
        if ( ! $value ) {
            throw new InvalidArgumentException('Fields for min cannot be empty or null. Provide a field for the builder.');
        }
        $_currentSelectField = new Minimum($value);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return SelectBuilder
     */
    public function max(string $value) : SelectBuilder
    {
        if ( ! $value ) {
            throw new InvalidArgumentException('Fields for max cannot be empty or null. Provide a field for the builder.');
        }
        $_currentSelectField = new Maximum($value);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return SelectBuilder
     */
    public function count(string $value) : SelectBuilder
    {
        if ( ! $value ) {
            throw new InvalidArgumentException('Fields for count cannot be empty or null. Provide a field for the builder.');
        }
        $_currentSelectField = new Count($value);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return SelectBuilder
     */
    public function sum(string $value) : SelectBuilder
    {
        if ( ! $value ) {
            throw new InvalidArgumentException('Fields for sum cannot be empty or null. Provide a field for the builder.');
        }
        $_currentSelectField = new Sum($value);
        $this->_selects[] = $_currentSelectField;

        return $this;
    }

    /**
     * @return SelectInterface[]
     */
    public function getFields()
    {
        return $this->_selects;
    }
}