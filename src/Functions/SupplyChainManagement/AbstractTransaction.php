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

namespace Intacct\Functions\SupplyChainManagement;

use Intacct\Fields\Date;
use Intacct\Functions\AbstractFunction;
use Intacct\Functions\Traits\CustomFieldsTrait;

abstract class AbstractTransaction extends AbstractFunction
{

    use CustomFieldsTrait;

    /** @var string */
    const STATE_DRAFT = 'Draft';

    /** @var string */
    const STATE_PENDING = 'Pending';

    /** @var string */
    const STATE_CLOSED = 'Closed';

    /** @var Date */
    protected $transactionDate;

    /** @var string */
    protected $referenceNumber;

    /** @var string */
    protected $message;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $state;

    /**
     * Initializes the class with the given parameters.
     *
     * @param array $params {
     * @todo finish me
     * }
     */
    public function __construct(array $params = [])
    {
        $defaults = [
            'transaction_date' => null,
            'reference_number' => null,
            'message' => null,
            'external_id' => null,
            'custom_fields' => [],
            'state' => null,
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->transactionDate = $config['transaction_date'];
        $this->referenceNumber = $config['reference_number'];
        $this->message = $config['message'];
        $this->externalId = $config['external_id'];
        $this->setCustomFields($config['custom_fields']);
        $this->state = $config['state'];
    }
}
