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

namespace Intacct\Xml;

class XMLWriter extends \XMLWriter
{

    /**
     * Sage Intacct date format
     *
     * @var string
     */
    const IA_DATE_FORMAT = 'm/d/Y';

    /**
     * Sage Intacct datetime format
     *
     * @var string
     */
    const IA_DATETIME_FORMAT = 'm/d/Y H:i:s';

    /**
     * Sage Intacct multi select string separator
     *
     * @var string
     */
    const IA_MULTI_SELECT_GLUE = '#~#';

    /**
     * @param string $name
     * @return bool
     */
    protected function isValidXmlName(string $name)
    {
        try {
            new \DOMElement($name);
            return true;
        } catch (\DOMException $ex) {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function startElement($name)
    {
        if ($this->isValidXmlName($name) === false) {
            throw new \InvalidArgumentException(
                '"' . $name . '" is not a valid name for an XML element'
            );
        }

        parent::startElement($name);
    }

    /**
     * Write full element tag
     *
     * @param string $name
     * @param mixed $content
     * @param bool $writeNull
     *
     * @return bool
     */
    public function writeElement($name, $content = null, $writeNull = false)
    {
        if ($this->isValidXmlName($name) === false) {
            throw new \InvalidArgumentException(
                '"' . $name . '" is not a valid name for an XML element'
            );
        }

        if ($content !== null || $writeNull === true) {
            $content = $this->transformValue($content);

            return parent::writeElement($name, $content);
        } else {
            return true;
        }
    }

    public function writeElementDate($name, $date = null, $format = self::IA_DATE_FORMAT, $writeNull = false)
    {
        if ($date instanceof \DateTime) {
            return self::writeElement($name, $date->format($format), $writeNull);
        } else {
            return self::writeElement($name, $date, $writeNull);
        }
    }

    public function writeElementDateTime($name, $date = null, $format = self::IA_DATETIME_FORMAT, $writeNull = false)
    {
        if ($date instanceof \DateTime) {
            return self::writeElement($name, $date->format($format), $writeNull);
        } else {
            return self::writeElement($name, $date, $writeNull);
        }
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    private function transformValue($value)
    {
        if (is_bool($value)) {
            $value = ($value === true) ? 'true' : 'false';
        } elseif ($value instanceof \DateTime) {
            // Default to date output
            $value = $value->format(self::IA_DATE_FORMAT);
        } elseif (is_array($value)) {
            $value = implode(self::IA_MULTI_SELECT_GLUE, $value);
        }
        return $value;
    }

    /**
     * Write full element date tags
     *
     * @param \DateTime $date
     * @param bool $writeNull
     *
     * @return bool
     */
    public function writeDateSplitElements(\DateTime $date, $writeNull = true)
    {
        list($year, $month, $day) = explode('-', $date->format('Y-m-d'));

        $this->writeElement('year', $year, $writeNull);
        $this->writeElement('month', $month, $writeNull);
        $this->writeElement('day', $day, $writeNull);

        return true;
    }

    /**
     * Write full attribute
     *
     * @param string $name
     * @param string $value
     * @param bool $writeNull
     *
     * @return bool
     */
    public function writeAttribute($name, $value, $writeNull = true)
    {
        if ($value !== null || $writeNull === true) {
            $value = $this->transformValue($value);

            return parent::writeAttribute($name, $value);
        } else {
            return true;
        }
    }
}
