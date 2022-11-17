<?php

require "../dbBroker.php";
require "../model/Ugovor.php";

if (isset($_POST['id']) && isset($_POST['potpisano']) && isset($_POST['datum_potpisa'])
    && isset($_POST['pas_id']) && isset($_POST['udomitelj_id'])) {

    if ($_POST['potpisano'] != 1) {
        $_POST['potpisano'] = 0;
    }
    

    $status = Ugovor::update($_POST['id'], $_POST['potpisano'], $_POST['datum_potpisa'], $_POST['pas_id'], $_POST['udomitelj_id'], $conn);
    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}
