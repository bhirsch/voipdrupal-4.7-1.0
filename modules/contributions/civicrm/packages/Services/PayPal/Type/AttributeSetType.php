<?php
/**
 * @package Services_PayPal
 */

/**
 * Make sure our parent class is defined.
 */
require_once 'Services/PayPal/Type/XSDType.php';

/**
 * AttributeSetType
 * 
 * AttributeSet.
 *
 * @package Services_PayPal
 */
class AttributeSetType extends XSDType
{
    var $Attribute;

    function AttributeSetType()
    {
        parent::XSDType();
        $this->_namespace = 'urn:ebay:apis:eBLBaseComponents';
        $this->_elements = array_merge($this->_elements,
            array (
              'Attribute' => 
              array (
                'required' => true,
                'type' => 'AttributeType',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
            ));
        $this->_attributes = array_merge($this->_attributes,
            array (
              'AttributeSetID' => 
              array (
                'name' => 'AttributeSetID',
                'type' => 'xs:string',
              ),
            ));
    }

    function getAttribute()
    {
        return $this->Attribute;
    }
    function setAttribute($Attribute, $charset = 'iso-8859-1')
    {
        $this->Attribute = $Attribute;
        $this->_elements['Attribute']['charset'] = $charset;
    }
}
