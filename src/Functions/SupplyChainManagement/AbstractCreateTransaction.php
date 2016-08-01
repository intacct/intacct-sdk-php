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

abstract class AbstractCreateTransaction extends AbstractTransaction
{

    /** @var string */
    protected $transactionDefinition;

    /** @var string */
    protected $createdFrom;

    /** @var string */
    protected $documentNumber;

    /** @var string */
    protected $baseCurrency;

    /** @var array */
    protected $entries;

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
            'transaction_definition' => null,
            'created_from' => null,
            'document_number' => null,
            'base_currency' => null,
            'entries' => [],
        ];
        $config = array_merge($defaults, $params);

        parent::__construct($config);

        $this->transactionDefinition = $config['transaction_definition'];
        $this->createdFrom = $config['created_from'];
        $this->documentNumber = $config['document_number'];
        $this->baseCurrency = $config['base_currency'];
        $this->entries = $config['entries'];
    }
}
