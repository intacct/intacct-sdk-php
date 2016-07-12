<?php


namespace Intacct\Functions;

use InvalidArgumentException;
use Intacct\Functions\Traits\DimensionsTrait;
use Intacct\Functions\Traits\CustomFieldsTrait;
use Intacct\Xml\XMLWriter;

class AbstractLineItem
{

    use DimensionsTrait;
    use CustomFieldsTrait;

    /**
     * @var string
     */
    private $accountLabel;

    /**
     * @var string
     */
    private $glAccountNumber;

    /**
     * @var string
     */
    private $offsetGLAccountNumber;

    /**
     * @var string|float
     */
    private $transactionAmount;

    /**
     * @var string
     */
    private $allocationId;

    /**
     * @var string
     */
    private $memo;

    /**
     * @var bool
     */
    private $form1099;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string|float
     */
    private $totalPaid;

    /**
     * @var string|float
     */
    private $totalDue;

    /**
     * @var bool
     */
    private $billable;

    /**
     *
     * @param array $params my params
     * @param string $functionControlId my function
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [], $functionControlId = null)
    {
        $defaults = [
            'account_label' => null,
            'gl_account_no' => null,
            'offset_gl_account_no' => null,
            'transaction_amount' => null,
            'allocation_id' => null,
            'memo' => null,
            'location_id' => null,
            'department_id' => null,
            'form_1099' => null,
            'key' => null,
            'total_paid' => null,
            'total_due' => null,
            'custom_fields' => [],
            'project_id' => null,
            'customer_id' => null,
            'vendor_id' => null,
            'employee_id' => null,
            'item_id' => null,
            'class_id' => null,
            'contract_id' => null,
            'warehouse_id' => null,
            'billable' => null,
        ];

        $config = array_merge($defaults, $params);

        $this->accountLabel = $config['account_label'];
        $this->glAccountNumber = $config['gl_account_no'];
        $this->offsetGLAccountNumber = $config['offset_gl_account_no'];
        $this->setTransactionAmount($config['transaction_amount']);
        $this->allocationId = $config['allocation_id'];
        $this->memo = $config['memo'];
        $this->setLocationId($config['location_id']);
        $this->setDepartmentId($config['department_id']);
        $this->setForm1099($config['form_1099']);
        $this->key = $config['key'];
        $this->setTotalPaid($config['total_paid']);
        $this->setTotalDue($config['total_due']);
        $this->setCustomFields($config['custom_fields']);
        $this->setProjectId($config['project_id']);
        $this->setCustomerId($config['customer_id']);
        $this->setVendorId($config['vendor_id']);
        $this->setEmployeeId($config['employee_id']);
        $this->setItemId($config['item_id']);
        $this->setClassId($config['class_id']);
        $this->setContractId($config['contract_id']);
        $this->setWarehouseId($config['warehouse_id']);
        $this->setBillable($config['billable']);
    }

    /**
     * @param $amount
     * @throws InvalidArgumentException
     */
    private function setTransactionAmount($amount)
    {
        if (!is_numeric($amount)) {
            throw new InvalidArgumentException('transaction_amount is not a valid number');
        }

        $this->transactionAmount = $amount;
    }

    /**
     * @param $form1099
     * @throws InvalidArgumentException
     */
    private function setForm1099($form1099)
    {
        // Do we need to do any validation?
        if (!is_bool($form1099) && !is_null($form1099)) {
            throw new InvalidArgumentException('form_1099 is not a valid bool');
        }

        $this->form1099 = $form1099;
    }

    /**
     * @param $totalPaid
     * @throws InvalidArgumentException
     */
    private function setTotalPaid($totalPaid)
    {
        if (!is_numeric($totalPaid) && !is_null($totalPaid)) {
            throw new InvalidArgumentException('total_paid is not a valid number');
        }

        $this->totalPaid = $totalPaid;
    }

    /**
     * @param $totalDue
     * @throws InvalidArgumentException
     */
    private function setTotalDue($totalDue)
    {
        if (!is_numeric($totalDue) && !is_null($totalDue)) {
            throw new InvalidArgumentException('total_due is not a valid number');
        }

        $this->totalDue = $totalDue;
    }

    /**
     * @param $billable
     * @throws InvalidArgumentException
     */
    private function setBillable($billable)
    {
        // Do we need to do any validation?
        if (!is_bool($billable) && !is_null($billable)) {
            throw new InvalidArgumentException('billable is not a valid bool');
        }

        $this->billable = $billable;
    }

    /**
     * @param XMLWriter $xml
     */
    public function getXml(XMLWriter &$xml)
    {
        $xml->startElement('lineitem');


        if (!is_null($this->accountLabel)) {
            $xml->writeElement('accountlabel', $this->accountLabel, true);
        } else {
            $xml->writeElement('glaccountno', $this->glAccountNumber, true);
        }

        $xml->writeElement('offsetglaccountno', $this->offsetGLAccountNumber);
        $xml->writeElement('amount', $this->transactionAmount, true);
        $xml->writeElement('allocationid', $this->allocationId);
        $xml->writeElement('memo' , $this->memo);
        $xml->writeElement('locationid', $this->getLocationId());
        $xml->writeElement('departmentid', $this->getDepartmentId());
        $xml->writeElement('item1099', $this->form1099);
        $xml->writeElement('key', $this->key);
        $xml->writeElement('totalpaid', $this->totalPaid);
        $xml->writeElement('totaldue', $this->totalDue);

        $this->getCustomFieldsXml($xml);

        $xml->writeElement('projectid', $this->getProjectId());
        $xml->writeElement('customerid', $this->getCustomerId());
        $xml->writeElement('vendorid', $this->getVendorId());
        $xml->writeElement('employeeid', $this->getEmployeeId());
        $xml->writeElement('itemid', $this->getItemId());
        $xml->writeElement('classid', $this->getClassId());
        $xml->writeElement('contractid', $this->getContractId());
        $xml->writeElement('warehouseid', $this->getWarehouseId());
        $xml->writeElement('billable', $this->billable);

        $xml->endElement(); //lineitem
    }
}