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

namespace Intacct\Functions\Company;

use Intacct\Functions\AbstractFunction;

abstract class AbstractAttachments extends AbstractFunction
{

    /** @var string */
    protected $attachmentsId;

    /** @var string */
    protected $attachmentsName;

    /** @var string */
    protected $attachmentFolderName;

    /** @var string */
    protected $description;

    /** @var AttachmentFile[] */
    protected $files;

    /**
     * @return string
     */
    public function getAttachmentsId()
    {
        return $this->attachmentsId;
    }

    /**
     * @param string $attachmentsId
     */
    public function setAttachmentsId($attachmentsId)
    {
        $this->attachmentsId = $attachmentsId;
    }

    /**
     * @return string
     */
    public function getAttachmentsName()
    {
        return $this->attachmentsName;
    }

    /**
     * @param string $attachmentsName
     */
    public function setAttachmentsName($attachmentsName)
    {
        $this->attachmentsName = $attachmentsName;
    }

    /**
     * @return string
     */
    public function getAttachmentFolderName()
    {
        return $this->attachmentFolderName;
    }

    /**
     * @param string $attachmentFolderName
     */
    public function setAttachmentFolderName($attachmentFolderName)
    {
        $this->attachmentFolderName = $attachmentFolderName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return AttachmentFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param AttachmentFile[] $files
     */
    public function setFiles(array $files)
    {
        $this->files = $files;
    }
}
