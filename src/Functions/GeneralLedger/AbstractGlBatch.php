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

namespace Intacct\Functions\GeneralLedger;

use Intacct\Fields\Date;
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractGlBatch extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    protected $journalSymbol;

    /** @var Date */
    protected $postingDate;

    /** @var Date */
    protected $reverseDate;

    /** @var string */
    protected $description;

    /** @var string */
    protected $historyComment;

    /** @var string */
    protected $referenceNumber;

    /** @var string */
    protected $sourceEntityId;

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $action;

    /** @var array */
    protected $entries;
}
