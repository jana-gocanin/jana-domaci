<?php
require "../dbBroker.php";
require "../model/Ugovor.php";


$status = Ugovor::getLast($conn);
if ($status) {
    echo $status->fetch_column();
} else {
    echo $status;
    echo 'Failed';
}
