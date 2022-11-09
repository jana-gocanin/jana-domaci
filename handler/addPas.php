<?php
require "../dbBroker.php";
require "../model/Pas.php";
if (
    isset($_POST['ime']) && isset($_POST['godine'])
    && isset($_POST['boja']) && isset($_POST['tezina'])
) {
    $status = Pas::add($_POST['ime'], $_POST['godine'], $_POST['boja'], $_POST['tezina'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}
