<?php
/**
 * @package Services_PayPal
 */

/**
 * Make sure our parent class is defined.
 */
require_once 'Services/PayPal/Type/XSDType.php';

/**
 * OptionType
 * 
 * OptionType - Type declaration to be used by other schemas. PayPal item options
 * for shopping cart.
 *
 * @package Services_PayPal
 */
class OptionType extends XSDType
{
    function OptionType()
    {
        parent::XSDType();
        $this->_namespace = 'urn:ebay:apis:eBLBaseComponents';
        $this->_attributes = array_merge($this->_attributes,
            array (
              'name' => 
              array (
                'name' => 'name',
                'type' => 'xs:string',
                'use' => 'required',
              ),
              'value' => 
              array (
                'name' => 'value',
                'type' => 'xs:string',
                'use' => 'required',
              ),
            ));
    }

}
