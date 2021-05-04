<?php
//echo "asdf";

include_once("unisender-init.php");

//echo "asdf";

//$mail_content = file_get_contents("mail.html");

//echo $mail_content;

$fn = fopen("emails.txt","r");

while ($email = fgets($fn)) {
    echo $email . " - ";
    Send_UniSenderMail($email, $email, "Важно!!! Смена пароля от сайта Agrotender.com.ua", "force_change_password", []);
    echo "\r\n";
}

//echo Send_UniSenderMail("kronas.sw@gmail.com", "kronas.sw@gmail.com", "Важно!!! Смена пароля от сайта Agrotender.com.ua", "force_change_password", []);

?>
