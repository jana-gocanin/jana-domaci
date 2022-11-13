<?php
require "../dbBroker.php";
require "../model/Ugovor.php";
require "../model/Pas.php";
require "../model/Udomitelj.php";

if (
    isset($_POST['potpisano']) && isset($_POST['datum_potpisa'])
    && isset($_POST['pas_id']) && isset($_POST['udomitelj_id'])
) {
    if ($_POST['potpisano'] != 1) {
        $_POST['potpisano'] = 0;
    }

    $pas = Pas::getById($_POST['pas_id'], $conn);
    $udomitelj = Udomitelj::getById($_POST['udomitelj_id'], $conn);

    if (empty($pas) || empty($udomitelj)) {
        echo 'Nije validan pas, ili udomitelj';
        die;
    }

    $postojeciUgovor = Ugovor::getByPasId($_POST['pas_id'], $conn);

    if (!empty($postojeciUgovor)) {
        echo 'Pas je vec udomljen!';
        die;
    }

    $status = Ugovor::add($_POST['potpisano'], $_POST['datum_potpisa'], $_POST['pas_id'], $_POST['udomitelj_id'], $conn);

    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}
