<?php


namespace Intacct\Functions\Traits;

use Intacct\Xml\XMLWriter;
use Intacct\Fields\Date;
use InvalidArgumentException;

trait ExchangeRateInfoTrait
{
    use ExchangeRateTypeTrait;

    /**
     *
     * @var string
     */
    private $baseCurrency;

    /**
     *
     * @var string
     */
    private $transactionCurrency;

    /**
     *
     * @var Date
     */
    private $exchangeRateDate;

    /**
     *
     * @var float
     */
    private $exchangeRateValue;

    /**
     * @param string $baseCurrency
     */
    public function setBaseCurrency($baseCurrency)
    {
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * @param string $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * @return string
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * @param string|Date $exchangeRateDate
     */
    public function setExchangeRateDate($exchangeRateDate)
    {
        if ($exchangeRateDate instanceof Date) {
            $this->exchangeRateDate = $exchangeRateDate;
        } else if (is_null($exchangeRateDate) == false) {
            $this->exchangeRateDate = new Date($exchangeRateDate);
        }
    }

    /**
     * @param string|number $exchangeRate
     * @throws InvalidArgumentException
     */
    public function setExchangeRateValue($exchangeRate)
    {
        if (is_numeric($exchangeRate) || is_null($exchangeRate)) {
            $this->exchangeRateValue = $exchangeRate;
        } else {
            throw new InvalidArgumentException('exchange_rate is not a valid number');
        }
    }

    /**
     * @param XMLWriter $xml
     */
    public function getExchangeRateInfoXml(XMLWriter $xml)
    {
        $xml->writeElement('basecurr', $this->baseCurrency);
        $xml->writeElement('currency', $this->transactionCurrency);

        if ($this->exchangeRateDate) {
            $xml->startElement('exchratedate');
            $xml->writeDateSplitElements($this->exchangeRateDate, true);
            $xml->endElement();
        }

        if ($this->exchangeRateType) {
            $xml->writeElement('exchratetype', $this->exchangeRateType);
        } else if ($this->exchangeRateValue) {
            $xml->writeElement('exchrate', $this->exchangeRateValue);
        } else if ($this->baseCurrency || $this->transactionCurrency) {
            $xml->writeElement('exchratetype', $this->exchangeRateType, true);
        }
    }

}