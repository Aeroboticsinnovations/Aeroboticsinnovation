<?php
if(!isset($_POST['email']) || !isset($_POST['subject']) || !isset($_POST['message'])){
    header('location:admin/index.php');
    exit;
}
// Establish database connection (assuming $conn is already defined)
include "admin/config/connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
// Validate reCAPTCHA




$newFileName = 'notfound.jpg';
// Handle form submission
$email = $_POST['email'];
$name = $_POST['name'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$email = mysqli_real_escape_string($conn, $email);
$subject = mysqli_real_escape_string($conn, $subject);
$message = mysqli_real_escape_string($conn, $message);
// Convert newlines to HTML line breaks
$message = nl2br($message);

// Escape special characters to prevent injection
$message = htmlspecialchars($message);

$name = mysqli_real_escape_string($conn, $name);




// Insert data into database
$sql = "INSERT INTO messages (email, subject, message) VALUES ('$email', '$subject', '$message')";
// echo $sql;
if (mysqli_query($conn, $sql)) {
    $lastInID  = mysqli_insert_id($conn);

    $getsql = "SELECT * FROM messages WHERE id = '$lastInID'";
    $rslt = mysqli_query($conn,$getsql);
    if(mysqli_num_rows($rslt) > 0 ){
        $dataa  = mysqli_fetch_assoc($rslt);
        $message = $dataa['message'];
    }

    $mailCandidate = new PHPMailer(true);

    try {
        //Server settings
        // $mailCandidate->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mailCandidate->isSMTP();                                            //Send using SMTP
        $mailCandidate->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mailCandidate->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mailCandidate->Username   = 'aeroboticscontact@gmail.com';                     //SMTP username
        $mailCandidate->Password   = 'zkvw afmb bgtp chfu';                               //SMTP password
        $mailCandidate->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mailCandidate->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mailCandidate->setFrom('aeroboticscontact@gmail.com', 'AEROBOTICS');
        $mailCandidate->addAddress($email, $name);     //Add a recipient
       
        $mailCandidate->ClearReplyTos();             
        $mailCandidate->addReplyTo('aeroboticscontact@gmail.com', 'AEROBOTICS');
        //Attachments
        // $mailCandidate->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mailCandidate->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mailCandidate->isHTML(true);                                  //Set email format to HTML
        $mailCandidate->Subject = $subject;
        $mailCandidate->Body    = '<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
      <html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
      
      <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta name="x-apple-disable-message-reformatting">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="telephone=no" name="format-detection">
        <title>New Template 3</title><!--[if (mso 16)]>
          <style type="text/css">
          a {text-decoration: none;}
          </style>
          <![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if gte mso 9]>
      <xml>
          <o:OfficeDocumentSettings>
          <o:AllowPNG></o:AllowPNG>
          <o:PixelsPerInch>96</o:PixelsPerInch>
          </o:OfficeDocumentSettings>
      </xml>
      <![endif]-->
        <style type="text/css">
          #outlook a {
            padding: 0;
          }
      
          .es-button {
            mso-style-priority: 100 !important;
            text-decoration: none !important;
          }
      
          a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
          }
      
          .es-desk-hidden {
            display: none;
            float: left;
            overflow: hidden;
            width: 0;
            max-height: 0;
            line-height: 0;
            mso-hide: all;
          }
      
          @media only screen and (max-width:600px) {
      
            p,
            ul li,
            ol li,
            a {
              line-height: 150% !important
            }
      
            h1,
            h2,
            h3,
            h1 a,
            h2 a,
            h3 a {
              line-height: 120% !important
            }
      
            h1 {
              font-size: 36px !important;
              text-align: left
            }
      
            h2 {
              font-size: 26px !important;
              text-align: left
            }
      
            h3 {
              font-size: 20px !important;
              text-align: left
            }
      
            .es-header-body h1 a,
            .es-content-body h1 a,
            .es-footer-body h1 a {
              font-size: 36px !important;
              text-align: left
            }
      
            .es-header-body h2 a,
            .es-content-body h2 a,
            .es-footer-body h2 a {
              font-size: 26px !important;
              text-align: left
            }
      
            .es-header-body h3 a,
            .es-content-body h3 a,
            .es-footer-body h3 a {
              font-size: 20px !important;
              text-align: left
            }
      
            .es-menu td a {
              font-size: 12px !important
            }
      
            .es-header-body p,
            .es-header-body ul li,
            .es-header-body ol li,
            .es-header-body a {
              font-size: 14px !important
            }
      
            .es-content-body p,
            .es-content-body ul li,
            .es-content-body ol li,
            .es-content-body a {
              font-size: 14px !important
            }
      
            .es-footer-body p,
            .es-footer-body ul li,
            .es-footer-body ol li,
            .es-footer-body a {
              font-size: 14px !important
            }
      
            .es-infoblock p,
            .es-infoblock ul li,
            .es-infoblock ol li,
            .es-infoblock a {
              font-size: 12px !important
            }
      
            *[class="gmail-fix"] {
              display: none !important
            }
      
            .es-m-txt-c,
            .es-m-txt-c h1,
            .es-m-txt-c h2,
            .es-m-txt-c h3 {
              text-align: center !important
            }
      
            .es-m-txt-r,
            .es-m-txt-r h1,
            .es-m-txt-r h2,
            .es-m-txt-r h3 {
              text-align: right !important
            }
      
            .es-m-txt-l,
            .es-m-txt-l h1,
            .es-m-txt-l h2,
            .es-m-txt-l h3 {
              text-align: left !important
            }
      
            .es-m-txt-r img,
            .es-m-txt-c img,
            .es-m-txt-l img {
              display: inline !important
            }
      
            .es-button-border {
              display: inline-block !important
            }
      
            a.es-button,
            button.es-button {
              font-size: 20px !important;
              display: inline-block !important
            }
      
            .es-adaptive table,
            .es-left,
            .es-right {
              width: 100% !important
            }
      
            .es-content table,
            .es-header table,
            .es-footer table,
            .es-content,
            .es-footer,
            .es-header {
              width: 100% !important;
              max-width: 600px !important
            }
      
            .es-adapt-td {
              display: block !important;
              width: 100% !important
            }
      
            .adapt-img {
              width: 100% !important;
              height: auto !important
            }
      
            .es-m-p0 {
              padding: 0 !important
            }
      
            .es-m-p0r {
              padding-right: 0 !important
            }
      
            .es-m-p0l {
              padding-left: 0 !important
            }
      
            .es-m-p0t {
              padding-top: 0 !important
            }
      
            .es-m-p0b {
              padding-bottom: 0 !important
            }
      
            .es-m-p20b {
              padding-bottom: 20px !important
            }
      
            .es-mobile-hidden,
            .es-hidden {
              display: none !important
            }
      
            tr.es-desk-hidden,
            td.es-desk-hidden,
            table.es-desk-hidden {
              width: auto !important;
              overflow: visible !important;
              float: none !important;
              max-height: inherit !important;
              line-height: inherit !important
            }
      
            tr.es-desk-hidden {
              display: table-row !important
            }
      
            table.es-desk-hidden {
              display: table !important
            }
      
            td.es-desk-menu-hidden {
              display: table-cell !important
            }
      
            .es-menu td {
              width: 1% !important
            }
      
            table.es-table-not-adapt,
            .esd-block-html table {
              width: auto !important
            }
      
            table.es-social {
              display: inline-block !important
            }
      
            table.es-social td {
              display: inline-block !important
            }
      
            .es-m-p5 {
              padding: 5px !important
            }
      
            .es-m-p5t {
              padding-top: 5px !important
            }
      
            .es-m-p5b {
              padding-bottom: 5px !important
            }
      
            .es-m-p5r {
              padding-right: 5px !important
            }
      
            .es-m-p5l {
              padding-left: 5px !important
            }
      
            .es-m-p10 {
              padding: 10px !important
            }
      
            .es-m-p10t {
              padding-top: 10px !important
            }
      
            .es-m-p10b {
              padding-bottom: 10px !important
            }
      
            .es-m-p10r {
              padding-right: 10px !important
            }
      
            .es-m-p10l {
              padding-left: 10px !important
            }
      
            .es-m-p15 {
              padding: 15px !important
            }
      
            .es-m-p15t {
              padding-top: 15px !important
            }
      
            .es-m-p15b {
              padding-bottom: 15px !important
            }
      
            .es-m-p15r {
              padding-right: 15px !important
            }
      
            .es-m-p15l {
              padding-left: 15px !important
            }
      
            .es-m-p20 {
              padding: 20px !important
            }
      
            .es-m-p20t {
              padding-top: 20px !important
            }
      
            .es-m-p20r {
              padding-right: 20px !important
            }
      
            .es-m-p20l {
              padding-left: 20px !important
            }
      
            .es-m-p25 {
              padding: 25px !important
            }
      
            .es-m-p25t {
              padding-top: 25px !important
            }
      
            .es-m-p25b {
              padding-bottom: 25px !important
            }
      
            .es-m-p25r {
              padding-right: 25px !important
            }
      
            .es-m-p25l {
              padding-left: 25px !important
            }
      
            .es-m-p30 {
              padding: 30px !important
            }
      
            .es-m-p30t {
              padding-top: 30px !important
            }
      
            .es-m-p30b {
              padding-bottom: 30px !important
            }
      
            .es-m-p30r {
              padding-right: 30px !important
            }
      
            .es-m-p30l {
              padding-left: 30px !important
            }
      
            .es-m-p35 {
              padding: 35px !important
            }
      
            .es-m-p35t {
              padding-top: 35px !important
            }
      
            .es-m-p35b {
              padding-bottom: 35px !important
            }
      
            .es-m-p35r {
              padding-right: 35px !important
            }
      
            .es-m-p35l {
              padding-left: 35px !important
            }
      
            .es-m-p40 {
              padding: 40px !important
            }
      
            .es-m-p40t {
              padding-top: 40px !important
            }
      
            .es-m-p40b {
              padding-bottom: 40px !important
            }
      
            .es-m-p40r {
              padding-right: 40px !important
            }
      
            .es-m-p40l {
              padding-left: 40px !important
            }
      
            button.es-button {
              width: 100%
            }
      
            .es-desk-hidden {
              display: table-row !important;
              width: auto !important;
              overflow: visible !important;
              max-height: inherit !important
            }
          }
      
          @media screen and (max-width:384px) {
            .mail-message-content {
              width: 414px !important
            }
          }
        </style>
      </head>
      
      <body
        style="width:100%;font-family:arial, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
        <div dir="ltr" class="es-wrapper-color" lang="en" style="background-color:#FAFAFA"><!--[if gte mso 9]>
                  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                      <v:fill type="tile" color="#fafafa"></v:fill>
                  </v:background>
              <![endif]-->
          <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" role="none"
            style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#FAFAFA">
            <tr>
              <td valign="top" style="padding:0;Margin:0">
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none"
                  style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                  <tr>
                    <td align="center" style="padding:0;Margin:0">
                      <table class="es-content-body"
                        style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"
                        cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center" role="none">
                        <tr>
                          <td align="left" style="padding:20px;Margin:0">
                            <table width="100%" cellspacing="0" cellpadding="0" role="none"
                              style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                              <tr>
                                <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                  <table width="100%" cellspacing="0" cellpadding="0" role="presentation"
                                    style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                    <tr>
                                      <td class="es-infoblock" align="center"
                                        style="padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC">
                                        <p
                                          style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica, sans-serif;line-height:14px;color:#CCCCCC;font-size:12px">
                                        
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
                
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none"
                  style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                  <tr>
                    <td align="center" style="padding:0;Margin:0">
                      <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center"
                        role="none"
                        style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                        <tr>
                          <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px">
                            <table width="100%" cellspacing="0" cellpadding="0" role="none"
                              style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                              <tr>
                                <td align="left" style="padding:0;Margin:0;width:560px">
                                  <table width="100%" cellspacing="0" cellpadding="0" role="presentation"
                                    style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                    <tr>
                                      <td class="es-m-txt-c" align="left"
                                        style="padding:0;Margin:0;padding-bottom:10px;padding-top:20px">
                                       
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        
                        <tr>
                          <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px">
                            <table width="100%" cellspacing="0" cellpadding="0" role="none"
                              style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                              <tr>
                                <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                  <table width="100%" cellspacing="0" cellpadding="0" role="presentation"
                                    style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                    <tr>
                                      <td align="left" style="padding:0;Margin:0;padding-top:5px;padding-bottom:10px">
                                        <p
                                          style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">
                                          Hi&nbsp;'.$name.'</p>
                                      </td>
                                    </tr>
                                    
                                    <tr>
                                      <td align="left" style="padding:0;Margin:0;padding-top:5px;padding-bottom:10px">
                                        <p> '.$message.'</p>
                                      </td>
                                    </tr>
                                    
                                    
                                  </table>
                                  <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none"
                                  style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                                  <tr>
                                    <td align="center" style="padding:0;Margin:0">
                                      <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center"
                                        role="none"
                                        style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                                        <tr>
                                          <td align="left"
                                            style="padding:0;Margin:0;padding-bottom:20px;padding-left:20px;padding-right:20px">
                                            <!--[if mso]><table style="width:560px" cellpadding="0" cellspacing="0"><tr><td style="width:237px" valign="top"><![endif]-->
                                            <table class="es-left" cellspacing="0" cellpadding="0" align="left" role="none"
                                              style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                              <tr>
                                                <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:237px">
                                                  <table width="100%" cellspacing="0" cellpadding="0" role="presentation"
                                                    style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tr>
                                                      <td align="center" style="padding:0;Margin:0"><span class="es-button-border"
                                                          style="border-style:solid;border-color:#5c68e2;background:#5c68e2;border-width:2px;display:inline-block;border-radius:5px;width:auto"><a
                                                            href="tel:+91 8547896007" class="es-button" target="_blank"
                                                            style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:20px;padding:10px 30px 10px 30px;display:inline-block;background:#5C68E2;border-radius:5px;font-family:arial, helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:24px;width:auto;text-align:center;mso-padding-alt:0;mso-border-alt:10px solid #5C68E2">CALL
                                                            </a></span></td>
                                                    </tr>
                                                  </table>
                                                </td>
                                              </tr>
                                            </table>
                                            <!--[if mso]></td><td style="width:20px"></td><td style="width:303px" valign="top"><![endif]-->
                                            <table class="es-right" cellspacing="0" cellpadding="0" align="right" role="none"
                                              style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                              <tr>
                                                <td align="left" style="padding:0;Margin:0;width:303px">
                                                  <table width="100%" cellspacing="0" cellpadding="0" role="presentation"
                                                    style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                                    <tr>
                                                      <td align="center" style="padding:0;Margin:0"><span class="es-button-border"
                                                          style="border-style:solid;border-color:#5c68e2;background:#ffffff;border-width:2px;display:inline-block;border-radius:5px;width:auto"><a
                                                            href="mailto:aeroboticscontact@gmail.com" class="es-button" target="_blank"
                                                            style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#5c68e2;font-size:20px;padding:10px 30px 10px 30px;display:inline-block;background:#ffffff;border-radius:5px;font-family:arial, helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:24px;width:auto;text-align:center;mso-padding-alt:0;mso-border-alt:10px solid  #ffffff">EMAIL
                                                            </a></span></td>
                                                    </tr>
                                                  </table>
                                                </td>
                                              </tr>
                                            </table><!--[if mso]></td></tr></table><![endif]-->
                                          </td>
                                        </tr>
                                      
                                      
                                        
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      
                    
                  
                      </table>
                    </td>
                  </tr>
                </table>
        
                <table class="es-footer" cellspacing="0" cellpadding="0" align="center" role="none"
                  style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                  <tr>
                    <td align="center" style="padding:0;Margin:0">
                      <table class="es-footer-body"
                        style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"
                        cellspacing="0" cellpadding="0" align="center" role="none">
                        <tr>
                          <td align="left"
                            style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px">
                            <table width="100%" cellspacing="0" cellpadding="0" role="none"
                              style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                              <tr>
                                <td align="left" style="padding:0;Margin:0;width:560px">
                                  <table width="100%" cellspacing="0" cellpadding="0" role="presentation"
                                    style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                    <tr>
                                      <td style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px;font-size:0"
                                        align="center">
                                        <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0"
                                          role="presentation"
                                          style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                          <tr>
                                            <td valign="top" align="center" style="padding:0;Margin:0;padding-right:40px"><img
                                                title="Facebook"
                                                src="https://feiazyc.stripocdn.email/content/assets/img/social-icons/logo-black/facebook-logo-black.png"
                                                alt="Fb" width="32"
                                                style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                            </td>
                                          
                                            <td valign="top" align="center" style="padding:0;Margin:0;padding-right:40px"><img
                                                title="Instagram"
                                                src="https://feiazyc.stripocdn.email/content/assets/img/social-icons/logo-black/instagram-logo-black.png"
                                                alt="Inst" width="32"
                                                style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                            </td>
                                            <td valign="top" align="center" style="padding:0;Margin:0"><img title="Youtube"
                                                src="https://feiazyc.stripocdn.email/content/assets/img/social-icons/logo-black/youtube-logo-black.png"
                                                alt="Yt" width="32"
                                                style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic">
                                            </td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                
                                    
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
                <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none"
                  style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                  <tr>
                    <td align="center" style="padding:0;Margin:0">
                      <table class="es-content-body"
                        style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px"
                        cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center" role="none">
                        <tr>
                          <td align="left" style="padding:20px;Margin:0">
                            <table width="100%" cellspacing="0" cellpadding="0" role="none"
                              style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                              <tr>
                                <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                  <table width="100%" cellspacing="0" cellpadding="0" role="presentation"
                                    style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                    <tr>
                                      <td class="es-infoblock" align="center"
                                        style="padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC">
                                        <p
                                          style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica, sans-serif;line-height:14px;color:#CCCCCC;font-size:12px">
                                          <a target="_blank" href=""
                                            style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px"></a>No
                                          longer want to receive these emails?&nbsp;<a href="https://website.com?unsub=true" target="_blank"
                                            style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px">Unsubscribe</a>.<a
                                            target="_blank" href=""
                                            style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px"></a>
                                        </p>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </body>
      
      </html>';
        // $mailCandidate->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mailCandidate->send();
        // echo "msg snd successfully.";
        // echo "<script>alert('Success');window.location.replace('contact.php?ad=false');</script>";
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mailCandidate->ErrorInfo}";
        // echo "<script>window.location.replace('contact.php?ad=false');</script>";
    }




    echo"<script> 
            
              window.location.href = 'admin/reg-form.php?inserted=success';
            </script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
