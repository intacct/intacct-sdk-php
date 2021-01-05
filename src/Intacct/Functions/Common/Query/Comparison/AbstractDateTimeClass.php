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

namespace Intacct\Functions\Common\Query\Comparison;

abstract class AbstractDateTimeClass extends AbstractComparison
{

    /**
     * @var string
     */
    const IA_DATE_FORMAT = 'm/d/Y'; // 12/31/2016

    /**
     * @var string
     */
    const IA_DATE_TIME_FORMAT = 'm/d/Y H:i:s'; // 12/31/2016 23:59:59

    /**
     * @var \DateTime
     */
    protected $value;

    /**
     * @var string
     */
    protected $format;

    /**
     * AbstractDateTimeClass constructor.
     *
     * @param string $format
     */
    public function __construct(string $format)
    {
        $this->setFormat($format);
    }

    /**
     * @return \DateTime
     */
    public function getValue(): \DateTime
    {
        return $this->value;
    }

    /**
     * @param \DateTime $value
     */
    public function setValue($value)
    {
        if (get_class($value) !== 'DateTime') {
            throw new \InvalidArgumentException('Comparison value variable must be a DateTime class');
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        if (!is_string($format)) {
            throw new \InvalidArgumentException(
                'Comparison format variable must be a string type.'
                . ' See http://php.net/manual/en/function.date.php for valid format characters.'
            );
        }
        $this->format = $format;
    }
}
