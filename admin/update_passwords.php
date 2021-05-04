<?php

//error_reporting(E_ALL);
//        include "../inc/db-inc.php";
//        include "../inc/connect-inc.php";

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}





//$res = mysqli_query($upd_link_db, "SELECT id, login FROM `agt_torg_buyer` ORDER BY id;");

while ($row = $res->fetch_assoc()) {
    $random_string = generateRandomString();
    $new_password = password_hash($random_string,  PASSWORD_DEFAULT);

    $sql = "UPDATE `agt_torg_buyer` SET passwd = '" . $new_password . "' WHERE id = " . $row["id"] . ";";
    echo $sql . "\r\n";

    mysqli_query($upd_link_db, $sql);

    echo $row["login"] . " - " . $new_password . "\r\n";
}




?>
