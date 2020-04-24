<?php

namespace Intacct\Functions\Common\QueryFilter;

class AndCondition extends AbstractCondition
{

    /**
     * @inheritDoc
     */
    public function getCondition() : string
    {
        return self:: AND;
    }
}