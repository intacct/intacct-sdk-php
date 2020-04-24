<?php

namespace Intacct\Functions\Common\QueryFilter;

use Intacct\Xml\XMLWriter;

abstract class AbstractCondition implements FilterInterface
{

    const OR = 'or';
    const AND = 'and';

    /**
     * @param FilterInterface[] $_filters
     */
    private $_filters;

    /**
     * AbstractCondition constructor.
     *
     * @param FilterInterface[] $_filters
     */
    public function __construct($_filters)
    {
        $this->_filters = $_filters;
    }

    /**
     * @return string
     */
    abstract public function getCondition() : string;

    /**
     * @param XMLWriter $xml
     */
    public function writeXML(XMLWriter $xml)
    {
        $xml->startElement($this->getCondition());
        foreach ( $this->_filters as $filter ) {
            if ( is_array($filter) ) //nested condition
            {
                $filter[0]->writeXML($xml);
            } else {
                $filter->writeXML($xml);
            }
        }
        $xml->endElement(); //and/or
    }
}