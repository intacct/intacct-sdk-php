<?php

/**
 * Created by PhpStorm.
 * User: cho
 * Date: 4/19/2016
 * Time: 1:04 PM
 */

namespace Intacct\Dimension;

use Intacct\IntacctClient;
use Intacct\IntacctObjectTrait;
use Intacct\Xml\Response\Operation\Result;

class IaClass
{

    use IntacctObjectTrait;

    private $client;

    public function __construct(IntacctClient &$client)
    {
        $this->client = $client;
    }

    /**
     * @param array $params
     * @return Result
     */
    public function create(array $params)
    {
        // Validation here...
        return $this->createObject($params, $this->client);
    }

    public function update(array $params)
    {
        return $this->updateObject($params, $this->client);
    }

    public function delete(array $params)
    {
        return $this->deleteObject($params, $this->client);
    }

    public function inspect(array $params)
    {
        return $this->inspectObject($params, $this->client);
    }
}