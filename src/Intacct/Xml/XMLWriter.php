<?php

/**
 * Copyright 2016 Intacct Corporation.
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

use Intacct\FieldTypes\DateType;
use DateTime;

class XMLWriter extends \XMLWriter
{

    /**
     * Intacct date format
     *
     * @var string
     */
    const IA_DATE_FORMAT = 'm/d/Y';

    /**
     * Intacct datetime format
     *
     * @var string
     * @todo review this is correct
     */
    const IA_DATETIME_FORMAT = 'm/d/Y H:i:s';

    /**
     * Write full element tag
     *
     * @param string $name
     * @param mixed $content
     * @param bool $writeNull
     *
     * @return bool
     * @todo Add all of the different field types we should support
     */
    public function writeElement($name, $content = null, $writeNull = false)
    {
        if ($content !== null || $writeNull === true) {
            if (is_bool($content)) {
                $content = ($content === true) ? 'true' : 'false';
            } elseif ($content instanceof DateType) {
                $content = $content->format(self::IA_DATE_FORMAT);
            } elseif ($content instanceof DateTime) {
                $content = $content->format(self::IA_DATETIME_FORMAT);
            }

            return parent::writeElement($name, $content);
        } else {
            return true;
        }
    }

    /**
     * Write full element date tags
     *
     * @param DateType $date
     * @param bool $writeNull
     *
     * @return bool
     */
    public function writeDateSplitElements(DateType $date, $writeNull = true)
    {
        list($year, $month, $day) = explode('-', $date->format('Y-m-d'));

        $this->writeElement('year', $year, $writeNull);
        $this->writeElement('month', $month, $writeNull);
        $this->writeElement('day', $day, $writeNull);

        return true;
    }
}
