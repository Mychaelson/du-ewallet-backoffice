<?php
namespace App\Library\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


/*
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'AKIAJKBW36PIFX5TMBTA';                 // SMTP username
$mail->Password = 'AjgXB3V6t9uS95zz9u030JjKHaj4T2DL2bVayf8zw63l';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to
*/

class Mailer
{
	
	const smtp_host = 'smtp.mandrillapp.com';
	const smtp_user = 'babydelora';
	const smtp_pass = 'mDf7PaCtVPmYxJ4WK6SIvA';
	const smtp_port = 587;
	const sender	  = 'register@tukangpos.org';
	const isHTML = TRUE;


	function __construct()
	{
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = self::smtp_host;
		$mail->SMTPAuth = true;
		$mail->Username = self::smtp_user;
		$mail->Password = self::smtp_pass;
		$mail->SMTPSecure = $this->smtp_secure;
		$mail->Port = self::smtp_port; 
	}

	public static function send_email($recipient, $subject, $message)
	{
		require 'PHPMailer/vendor/autoload.php';
		$mail = new PHPMailer(true);
		$mail->setFrom(self::sender, 'IDNLIVE');
		$mail->addAddress($recipient);     
		$mail->isHTML(self::isHTML);
		$mail->Subject = $subject;
		$mail->Body    = $message;

		// if(!$mail->send()) 
		// {
		// 	// Return for error
		//     return $mail->ErrorInfo;
		// }

		return 'EmailSent';
	}
}