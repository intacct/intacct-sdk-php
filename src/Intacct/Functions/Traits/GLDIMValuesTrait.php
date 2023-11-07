<?php

namespace Intacct\Functions\Traits;

use Intacct\Xml\XMLWriter;

trait GLDIMValuesTrait
{
	protected $gldimValues = [];

	protected function writeGLDIMValuesToXml(XMLWriter $xml): void {
		foreach ($this->gldimValues as $fieldName => $value) {
			$xml->writeElement($fieldName, $value, true);
		}
	}

	public function setGLDIMValue(string $dimension, string $value): void {
		$this->gldimValues[$dimension] = $value;
	}

	public function getGLDIMValue(string $dimension): ?string {
		return $this->gldimValues[$dimension];
	}
}