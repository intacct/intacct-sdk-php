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

abstract class AbstractAttachmentsFolder extends AbstractFunction
{

    /** @var string */
    protected $folderName;

    /** @var string */
    protected $description;

    /** @var string */
    protected $parentFolderName;

    /**
     * Get folder name
     *
     * @return string
     */
    public function getFolderName()
    {
        return $this->folderName;
    }

    /**
     * Set folder name
     *
     * @param string $folderName
     */
    public function setFolderName($folderName)
    {
        $this->folderName = $folderName;
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
     * Get parent folder name
     *
     * @return string
     */
    public function getParentFolderName()
    {
        return $this->parentFolderName;
    }

    /**
     * Set parent folder name
     *
     * @param string $parentFolderName
     */
    public function setParentFolderName($parentFolderName)
    {
        $this->parentFolderName = $parentFolderName;
    }
}
