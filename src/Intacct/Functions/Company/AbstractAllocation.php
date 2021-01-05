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

namespace Intacct\Functions\Company;

use Intacct\Functions\AbstractFunction;

abstract class AbstractAllocation extends AbstractFunction
{

    /** @var string */
    const ALLOCATE_BY_PERCENTAGE = 'Percentage';

    /** @var string */
    const ALLOCATE_BY_ABSOLUTE = 'Absolute';

    /** @var string */
    private $allocationId;

    /** @var string */
    private $description;

    /** @var string */
    private $documentNo;

    /** @var string */
    private $allocateBy;

    /** @var string */
    private $attachmentsId;

    /** @var bool */
    private $active;

    /** @var AbstractAllocationLine[] */
    private $lines = [];

    /**
     * Get allocation ID
     *
     * @return string
     */
    public function getAllocationId()
    {
        return $this->allocationId;
    }

    /**
     * Set allocation ID
     *
     * @param string $allocationId
     */
    public function setAllocationId($allocationId)
    {
        $this->allocationId = $allocationId;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get document number
     *
     * @return string
     */
    public function getDocumentNo()
    {
        return $this->documentNo;
    }

    /**
     * Set document number
     *
     * @param string $documentNo
     */
    public function setDocumentNo($documentNo)
    {
        $this->documentNo = $documentNo;
    }

    /**
     * Get allocate by
     *
     * @return string
     */
    public function getAllocateBy()
    {
        return $this->allocateBy;
    }

    /**
     * Set allocate by
     *
     * @param string $allocateBy
     */
    public function setAllocateBy($allocateBy)
    {
        $this->allocateBy = $allocateBy;
    }

    /**
     * Get attachments ID
     *
     * @return string
     */
    public function getAttachmentsId()
    {
        return $this->attachmentsId;
    }

    /**
     * Set attachments ID
     *
     * @param string $attachmentsId
     */
    public function setAttachmentsId($attachmentsId)
    {
        $this->attachmentsId = $attachmentsId;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get allocation lines
     *
     * @return AbstractAllocationLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Set allocation lines
     *
     * @param AbstractAllocationLine[] $lines
     */
    public function setLines(array $lines)
    {
        $this->lines = $lines;
    }
}
