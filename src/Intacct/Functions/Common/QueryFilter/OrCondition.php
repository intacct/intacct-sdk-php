<?php

namespace Intacct\Functions\Common\QueryFilter;

class OrCondition extends AbstractCondition
{

    /**
     * @inheritDoc
     */
    public function getCondition() : string
    {
        return self:: OR;
    }
}