<?php
/**
 * @package Services_PayPal
 */

/**
 * Make sure our parent class is defined.
 */
require_once 'Services/PayPal/Type/XSDType.php';

/**
 * MerchantPullPaymentType
 * 
 * MerchantPullPayment - Type declaration to be used by other schemas. Parameters
 * to make initiate a pull payment
 *
 * @package Services_PayPal
 */
class MerchantPullPaymentType extends XSDType
{
    var $Amount;

    var $MpID;

    var $PaymentType;

    var $Memo;

    var $EmailSubject;

    var $Tax;

    var $Shipping;

    var $Handling;

    var $ItemName;

    var $ItemNumber;

    var $Invoice;

    var $Custom;

    var $ButtonSource;

    function MerchantPullPaymentType()
    {
        parent::XSDType();
        $this->_namespace = 'urn:ebay:apis:eBLBaseComponents';
        $this->_elements = array_merge($this->_elements,
            array (
              'Amount' => 
              array (
                'required' => true,
                'type' => 'BasicAmountType',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'MpID' => 
              array (
                'required' => true,
                'type' => 'MerchantPullIDType',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'PaymentType' => 
              array (
                'required' => false,
                'type' => 'MerchantPullPaymentCodeType',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'Memo' => 
              array (
                'required' => false,
                'type' => 'string',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'EmailSubject' => 
              array (
                'required' => false,
                'type' => 'string',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'Tax' => 
              array (
                'required' => false,
                'type' => 'BasicAmountType',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'Shipping' => 
              array (
                'required' => false,
                'type' => 'BasicAmountType',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'Handling' => 
              array (
                'required' => false,
                'type' => 'BasicAmountType',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'ItemName' => 
              array (
                'required' => false,
                'type' => 'string',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'ItemNumber' => 
              array (
                'required' => false,
                'type' => 'string',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'Invoice' => 
              array (
                'required' => false,
                'type' => 'string',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'Custom' => 
              array (
                'required' => false,
                'type' => 'string',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
              'ButtonSource' => 
              array (
                'required' => false,
                'type' => 'string',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
            ));
    }

    function getAmount()
    {
        return $this->Amount;
    }
    function setAmount($Amount, $charset = 'iso-8859-1')
    {
        $this->Amount = $Amount;
        $this->_elements['Amount']['charset'] = $charset;
    }
    function getMpID()
    {
        return $this->MpID;
    }
    function setMpID($MpID, $charset = 'iso-8859-1')
    {
        $this->MpID = $MpID;
        $this->_elements['MpID']['charset'] = $charset;
    }
    function getPaymentType()
    {
        return $this->PaymentType;
    }
    function setPaymentType($PaymentType, $charset = 'iso-8859-1')
    {
        $this->PaymentType = $PaymentType;
        $this->_elements['PaymentType']['charset'] = $charset;
    }
    function getMemo()
    {
        return $this->Memo;
    }
    function setMemo($Memo, $charset = 'iso-8859-1')
    {
        $this->Memo = $Memo;
        $this->_elements['Memo']['charset'] = $charset;
    }
    function getEmailSubject()
    {
        return $this->EmailSubject;
    }
    function setEmailSubject($EmailSubject, $charset = 'iso-8859-1')
    {
        $this->EmailSubject = $EmailSubject;
        $this->_elements['EmailSubject']['charset'] = $charset;
    }
    function getTax()
    {
        return $this->Tax;
    }
    function setTax($Tax, $charset = 'iso-8859-1')
    {
        $this->Tax = $Tax;
        $this->_elements['Tax']['charset'] = $charset;
    }
    function getShipping()
    {
        return $this->Shipping;
    }
    function setShipping($Shipping, $charset = 'iso-8859-1')
    {
        $this->Shipping = $Shipping;
        $this->_elements['Shipping']['charset'] = $charset;
    }
    function getHandling()
    {
        return $this->Handling;
    }
    function setHandling($Handling, $charset = 'iso-8859-1')
    {
        $this->Handling = $Handling;
        $this->_elements['Handling']['charset'] = $charset;
    }
    function getItemName()
    {
        return $this->ItemName;
    }
    function setItemName($ItemName, $charset = 'iso-8859-1')
    {
        $this->ItemName = $ItemName;
        $this->_elements['ItemName']['charset'] = $charset;
    }
    function getItemNumber()
    {
        return $this->ItemNumber;
    }
    function setItemNumber($ItemNumber, $charset = 'iso-8859-1')
    {
        $this->ItemNumber = $ItemNumber;
        $this->_elements['ItemNumber']['charset'] = $charset;
    }
    function getInvoice()
    {
        return $this->Invoice;
    }
    function setInvoice($Invoice, $charset = 'iso-8859-1')
    {
        $this->Invoice = $Invoice;
        $this->_elements['Invoice']['charset'] = $charset;
    }
    function getCustom()
    {
        return $this->Custom;
    }
    function setCustom($Custom, $charset = 'iso-8859-1')
    {
        $this->Custom = $Custom;
        $this->_elements['Custom']['charset'] = $charset;
    }
    function getButtonSource()
    {
        return $this->ButtonSource;
    }
    function setButtonSource($ButtonSource, $charset = 'iso-8859-1')
    {
        $this->ButtonSource = $ButtonSource;
        $this->_elements['ButtonSource']['charset'] = $charset;
    }
}
