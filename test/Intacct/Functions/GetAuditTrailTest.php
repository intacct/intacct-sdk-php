<?php


namespace Intacct\Functions;

use Intacct\Xml\XMLWriter;
use InvalidArgumentException;

class GetAuditTrailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Intacct\Functions\GetAuditTrail::__construct
     * @covers Intacct\Functions\GetAuditTrail::getObjectName
     * @covers Intacct\Functions\GetAuditTrail::setObjectName
     * @covers Intacct\Functions\GetAuditTrail::setControlId
     * @covers Intacct\Functions\GetAuditTrail::getControlId
     * @covers Intacct\Functions\GetAuditTrail::setObjectKey
     * @covers Intacct\Functions\GetAuditTrail::getXml
     */
    public function testDefaultParams()
    {
        $expected = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<function controlid="unittest">
    <getObjectTrail>
        <object>GLENTRY</object>
        <objectKey>GLENTRY123</objectKey>
    </getObjectTrail>
</function>
EOF;

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->setIndent(true);
        $xml->setIndentString('    ');
        $xml->startDocument();

        $getAuditTrail = new GetAuditTrail([
            'object' => 'GLENTRY',
            'control_id' => 'unittest',
            'object_key' => 'GLENTRY123'
        ]);
        $getAuditTrail->getXml($xml);

        $this->assertXmlStringEqualsXmlString($expected, $xml->flush());
    }

    /**
     * @covers Intacct\Functions\GetAuditTrail::__construct
     * @covers Intacct\Functions\GetAuditTrail::setObjectKey
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Required "object_key" not supplied in params
     */
    public function testNoObjectKey()
    {
        new GetAuditTrail([
            'object' => 'GLENTRY',
            'control_id' => 'unittest',
        ]);
    }

    /**
     * @covers Intacct\Functions\GetAuditTrail::__construct
     * @covers Intacct\Functions\GetAuditTrail::setObjectKey
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage object_key must be a string
     */
    public function testInvalidObjectKey()
    {
        new GetAuditTrail([
            'object' => 'GLENTRY',
            'control_id' => 'unittest',
            'object_key' => 203985725309,
        ]);
    }
}
