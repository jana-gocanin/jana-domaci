<?php
require "../dbBroker.php";
require "../model/Ugovor.php";

if (isset($_POST['id'])) {
    $status = Ugovor::deleteById($_POST['id'], $conn);

    if ($status) {
        echo 'Success';
    } else {
        echo "Failed";
    }
}