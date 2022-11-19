<?php
require "../dbBroker.php";
require "../model/Pas.php";


$status = Pas::getLast($conn);
if ($status) {
    $result = $status->fetch_assoc();
    echo json_encode($result);
} else {
    echo $status;
    echo 'Failed';
}
