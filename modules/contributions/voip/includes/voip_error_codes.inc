<?php
/* $Id: voip_error_codes.inc,v 1.1 2006/09/07 17:58:47 leob Exp $ */

/**
 * @file
 * Defines error code constants for voip functionality
 *
 */


// -----------------------------------------------------------------------------
// constants
// -----------------------------------------------------------------------------

define('VOIP_SUCCESS', 1);
define('VOIP_PROCESSING_FAILURE', -1);
define('VOIP_INVALID_EXTENSION_NUMBER', -2);
define('VOIP_INVALID_PHONE_PIN', -3);
define('VOIP_INVALID_USER_INFO', -4);
define('VOIP_INVALID_EXTENSION_PASSWORD_COMBINATION', -5);
define('VOIP_LACK_OF_PERMISSION', -6);
define('VOIP_EXTENSION_DOES_NOT_EXIST', -7);
define('VOIP_INVALID_NID', -8);

define('VOIP_VOICEMAIL_MAILBOX_DOES_NOT_EXIST', -20);
define('VOIP_VOICEMAIL_MAILBOX_NOT_ACTIVE', -21);


// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------

?>
