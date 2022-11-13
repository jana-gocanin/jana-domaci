<?php
require "../dbBroker.php";
require "../model/Ugovor.php";


$status = Ugovor::getLast($conn);
if ($status) {
    $result = $status->fetch_assoc();
    $result['datum_potpisa'] = date("d-m-Y", strtotime($result['datum_potpisa']));
    echo json_encode($result);
} else {
    echo $status;
    echo 'Failed';
}
