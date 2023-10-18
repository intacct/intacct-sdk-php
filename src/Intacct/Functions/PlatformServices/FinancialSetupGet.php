<?php

namespace Intacct\Functions\PlatformServices;

use Intacct\Functions\AbstractFunction;
use Intacct\Xml\XMLWriter;

class FinancialSetupGet extends AbstractFunction {

	public function writeXml(XMLWriter &$xml) {
		$xml->startElement('function');
		$xml->writeAttribute('controlid', $this->controlId, true);
		$xml->writeElement('getFinancialSetup', null, true);
		$xml->endElement(); // function
	}
}