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

use DateTime;

class XMLWriter extends \XMLWriter
{

    /**
     * @param string $name
     * @param null $content
     * @param bool $writeNull
     *
     * @return bool
     */
    public function writeElement($name, $content = null, $writeNull = false)
    {
        if (
            (
                $content !== null
                && $content !== ''
            )
            || $writeNull === true
        ) {
            if (is_bool($content)) {
                $content = ($content) ? 'true' : 'false';
            }
            //TODO add date, datetime, etc

            return parent::writeElement($name, $content);

        } else {
            return true;
        }
    }

    /**
     * @param DateTime $date
     * @param bool $writeNull
     *
     * @return bool
     */
    public function writeDateSplitElements(DateTime $date, $writeNull = true)
    {
        list($year, $month, $day) = explode('-', $date->format('Y-m-d'));

        $this->writeElement('year', $year, $writeNull);
        $this->writeElement('month', $month, $writeNull);
        $this->writeElement('day', $day, $writeNull);

        return true;
    }
    
}