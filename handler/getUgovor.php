<?php

require "../dbBroker.php";
require "../model/Ugovor.php";

if(isset($_POST['id'])) {
    $myArray = Ugovor::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}
