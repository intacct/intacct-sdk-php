<?php

namespace Intacct\Functions\Common\QueryFilter;

use Intacct\Xml\XMLWriter;

interface FilterInterface
{

    /**
     * @param XMLWriter $xml
     */
    public function writeXML(XMLWriter $xml);
}