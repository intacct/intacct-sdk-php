<?php

namespace Intacct\Functions\Common;

interface FilterBuilderInterface
{

    /**
     * @return string
     */
    public function getField() : string;

    /**
     * @param string $field
     *
     * @return FilterBuilderInterface
     */
    public function setField(string $field) : FilterBuilderInterface;

    /**
     * @param string $field
     *
     * @return mixed
     */
    public function where(string $field);

    /**
     * @return string
     */
    public function getValue() : string;

    /**
     * @param string $value
     *
     * @return FilterBuilderInterface
     */
    public function setValue(string $value) : FilterBuilderInterface;

    /**
     * @param string $value
     *
     * @return FilterBuilderInterface
     */
    public function equalto(string $value) : FilterBuilderInterface;
}