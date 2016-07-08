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

namespace Intacct\Functions\Traits;

use Intacct\Fields\Date;

trait DueDateTrait
{

    /**
     *
     * @var Date
     */
    private $dueDate;

    /**
     * @return Date
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param string|Date $dueDate
     */
    public function setDueDate($dueDate)
    {
        if (is_null($dueDate) || ($dueDate instanceof Date)) {
            $this->dueDate = $dueDate;
        } else {
            $this->dueDate = new Date($dueDate);
        }
    }

}