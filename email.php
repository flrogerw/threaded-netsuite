#!/usr/bin/php
<?php

require_once 'Mail.php';
$logs1 = "";
Send_Mail_Relay($logs1);        


function Send_Mail_Relay($logs){

    $from = "Polaroid Fotobar<it@polaroidfotobar.com";
    $to = "rogerw@polaroidfotobar.com";
    $subject = "Shit Broke";
    $body = "<br><br>TESTING.\n";

    $host = "162.242.197.97";
    $username = "mailrelay@fotobar.com";
    $password = "m06Ar14u";

    $headers = array ('From' => $from,
      'To' => $to,
      'Subject' => $subject);
    $smtp =& Mail::factory('smtp',
      array ('host' => $host,
        'auth' => true,
        'username' => $username,
        'password' => $password));

    $mail = $smtp->send($to, $headers, $body);

    
   if (PEAR::isError($mail)) {
      echo("<p>" . $mail->getMessage() . "</p>");
     } else {
      echo("<p>Message successfully sent!</p>");
    }
}
