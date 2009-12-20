<?php

/*//////////////////////////////////////////////////////////////////////////////
function: _mail
arguments: $sender, $recipient, $cc (optional), $bcc (optional), $subject, $body, $file
synopsis: send an email from $sender to $recipient with attachment $file 
notes: this could be improved by making $file an array of files or filenames. Also, some people reported problems receiving attachments via this code. I did not have the resources to follow-up on the issue. YMMV.
return status: 1 (success), 0 (error)
author: Saul Baizman (zool at baizman dot net)
last modified: Wed Jun 21 14:12:24 EDT 2006
//////////////////////////////////////////////////////////////////////////////*/

// FIXME: is $file simply a pathname or the file contents?
// WARNING: this function implements little to no error checking or input validation! 

function _voip_voicemail_mail($sender, $recipient, $cc = '' , $bcc = '', $subject, $body, $file ) {

  // add CC recipients to headers
  if (!empty($cc)) {
    $mail_headers .= 'CC: ' . $cc . "\r\n" ;
  }

  // add BCC recipients to headers
  if (!empty($bcc)) {
    $mail_headers .= 'BCC: ' . $bcc . "\r\n" ;
  }

  // info snagged from the Zend website
  $mail_headers .= 'MIME-Version: 1.0' . "\r\n" ;

  // Define MIME boundary
  $mime_boundary = '=====' . md5 ( uniqid ( time ( ) ) ) ;
  $mail_headers .= 'Content-type: multipart/mixed; boundary="' . $mime_boundary . '"' . "\n\n" ;
  $mail_headers .= '--' . $mime_boundary . "\r\n" ;

	// FIXME: character set may need to be altered for other languages
	$mail_headers .= 'Content-Type: text/plain; charset="iso-8859-1"' . "\r\n" ;

	// FIXME: encoding may need to be altered for other languages
	$mail_headers .= 'Content-Transfer-Encoding: 7bit' . "\r\n" ;

	// include body of message
	$mail_headers .= wordwrap ( $body, 70 ) . "\r\n" ;

	$mail_headers .= '--' . $mime_boundary . "\r\n" ;

	// add content type of audio/x-mpg for mp3 file
	// name the email attachment "voicemail-message.mp3"
	$mail_headers .= 'Content-Type: audio/x-mpg; name="voicemail-message.mp3"' . "\r\n" ;

	$mail_headers .= 'Content-Transfer-Encoding: base64' . "\r\n" ;

	$mail_headers .= 'Content-Description: voicemail-message.mp3' . "\r\n" ;

	$mail_headers .= 'Content-Disposition: attachment; filename="voicemail-message.mp3"' . "\r\n\r\n" ;

	$mail_headers .= chunk_split ( base64_encode ( $file ) ) . "\r\n" ;

	$mail_headers .= '--' . $mime_boundary . "\r\n" ;

	// end of MIME encoding

	$headers = "From: $sender\r\n" ;
	$headers .= $mail_headers ;

	if ( ! mail ( $recipient, $subject, '', $headers ) )
	{
		return 0 ;
	}

	return 1 ;

}

include 'email-function-for-leo.php' ;

// INSTRUCTIONS: CHANGE THE VALUES BELOW TO TEST THE "_mail" FUNCTION!

// define test mp3 file
// $test_file = 'voicemail-test-file.mp3' ;
$test_file = '' ;

// read it into a variable as a string
// [ function file_get_contents requires PHP 4 >= 4.3.0 ]
$file = file_get_contents ( $test_file ) ;

// define test email properties
// $sender = 'doNotReply@notification.com' ;
$sender = 'doNotReply@nowhere.com' ;

// $recipient = 'address1@email.com' ;
$recipient = '' ;
// $cc = 'address2@email.com' ;
$cc = '' ;
// $bcc = 'address3@email.com' ;
$bcc = '' ;

$subject = 'You received a new voicemail!' ;

// here document for body
$body =<<<EOM
Dear Name,

You have a new voicemail.

See the attached file.

Sincerely,
The voicemail droid

EOM;

$return = _mail ( $sender, $recipient, $cc, $bcc, $subject, $body, $file ) ;

// status message
if ( $return )
{
?>
Message from <?=$sender?> to <?=$recipient?> re: "<?=$subject?>" sent successfully.
<?
}
else
{
?>
Message from <?=$sender?> to <?=$recipient?> re: "<?=$subject?>" sent NOT successfully.
<?
}

?>
?>
