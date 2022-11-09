<?php
require "../dbBroker.php";
require "../model/Udomitelj.php";

if (
    isset($_POST['ime']) && isset($_POST['prezime'])
    && isset($_POST['datum_rodjenja']) && isset($_POST['email'])
) {
    $status = Udomitelj::add($_POST['ime'], $_POST['prezime'], $_POST['datum_rodjenja'], $_POST['email'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}
