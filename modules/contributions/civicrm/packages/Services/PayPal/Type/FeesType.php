<?php
/**
 * @package Services_PayPal
 */

/**
 * Make sure our parent class is defined.
 */
require_once 'Services/PayPal/Type/XSDType.php';

/**
 * FeesType
 * 
 * Following are the current set of eBay fee types AuctionLengthFee BoldFee
 * BuyItNowFee CategoryFeaturedFee FeaturedFee FeaturedGalleryFee
 * FixedPriceDurationFee GalleryFee GiftIconFee HighLightFee InsertionFee
 * ListingDesignerFee ListingFee PhotoDisplayFee PhotoFee ReserveFee SchedulingFee
 * ThirtyDaysAucFee Instances of this type could hold one or more supported types
 * of fee.
 *
 * @package Services_PayPal
 */
class FeesType extends XSDType
{
    var $Fee;

    function FeesType()
    {
        parent::XSDType();
        $this->_namespace = 'urn:ebay:apis:eBLBaseComponents';
        $this->_elements = array_merge($this->_elements,
            array (
              'Fee' => 
              array (
                'required' => true,
                'type' => 'FeeType',
                'namespace' => 'urn:ebay:apis:eBLBaseComponents',
              ),
            ));
    }

    function getFee()
    {
        return $this->Fee;
    }
    function setFee($Fee, $charset = 'iso-8859-1')
    {
        $this->Fee = $Fee;
        $this->_elements['Fee']['charset'] = $charset;
    }
}
