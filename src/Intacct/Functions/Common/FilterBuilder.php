<?php

namespace Intacct\Functions\Common;

use Intacct\Xml\XMLWriter;

class FilterBuilder implements FilterBuilderInterface
{

    /**
     * @var string
     */
    private $_field;

    /**
     * @var string
     */
    private $_value;

    /**
     * FilterBuilder constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getField() : string
    {
        return $this->_field;
    }

    /**
     * @param string $field
     *
     * @return FilterBuilderInterface
     */
    public function setField(string $field) : FilterBuilderInterface
    {
        $this->_field = $field;

        return $this;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function where(string $field)
    {
        $this->setField($field);

        return $this;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->_value;
    }

    /**
     * @param string $value
     *
     * @return FilterBuilderInterface
     */
    public function setValue(string $value) : FilterBuilderInterface
    {
        $this->_value = $value;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function equalto(string $value) : FilterBuilderInterface
    {
        $this->setValue($value);

        return $this;
    }

    /**
     * @param XMLWriter $xml
     */
    public function writeXML(XMLWriter $xml)
    {
        $xml->startElement('filter');

        $xml->startElement('equalto');

        $xml->writeElement('field', $this->_field, false);
        $xml->writeElement('value', $this->_value, false);

        $xml->endElement(); //equalto

        $xml->endElement(); //filter
    }
}