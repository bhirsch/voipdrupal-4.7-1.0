<?php
  /*
   +--------------------------------------------------------------------+
   | CiviCRM version 1.4                                                |
   +--------------------------------------------------------------------+
   | Copyright (c) 2005 Donald A. Lobo                                  |
   +--------------------------------------------------------------------+
   | This file is a part of CiviCRM.                                    |
   |                                                                    |
   | CiviCRM is free software; you can copy, modify, and distribute it  |
   | under the terms of the Affero General Public License Version 1,    |
   | March 2002.                                                        |
   |                                                                    |
   | CiviCRM is distributed in the hope that it will be useful, but     |
   | WITHOUT ANY WARRANTY; without even the implied warranty of         |
   | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
   | See the Affero General Public License for more details.            |
   |                                                                    |
   | You should have received a copy of the Affero General Public       |
   | License along with this program; if not, contact the Social Source |
   | Foundation at info[AT]socialsourcefoundation[DOT]org.  If you have |
   | questions about the Affero General Public License or the licensing |
   | of CiviCRM, see the Social Source Foundation CiviCRM license FAQ   |
   | at http://www.openngo.org/faqs/licensing.html                      |
   +--------------------------------------------------------------------+
  */

  /**
   *
   *
   * @package CRM
   * @author Donald A. Lobo <lobo@yahoo.com>
   * @copyright Donald A. Lobo (c) 2005
   * $Id$
   *
   */


require_once 'CRM/Contribute/DAO/FinancialTrxn.php';

class CRM_Contribute_BAO_FinancialTrxn extends CRM_Contribute_DAO_FinancialTrxn
{
    function CRM_Contribute_BAO_FinancialTrxn()
    {
        parent::CRM_Contribute_DAO_FinancialTrxn();
    }
    
    /**
     * takes an associative array and creates a financial transaction object
     *
     * @param array  $params (reference ) an assoc array of name/value pairs
     *
     * @return object CRM_Contribute_BAO_FinancialTrxn object
     * @access public
     * @static
     */
     function create(&$params) {
        $trxn =& new CRM_Contribute_DAO_FinancialTrxn();
        
        $trxn->copyValues($params);
        $trxn->domain_id = CRM_Core_Config::domainID( );
        
        require_once 'CRM/Utils/Rule.php';
        if (!CRM_Utils_Rule::currencyCode($contribution->currency)) {
            require_once 'CRM/Core/Config.php';
            $config =& CRM_Core_Config::singleton();
            $contribution->currency = $config->defaultCurrency;
        }
        
        return $trxn->save();
    }

}
