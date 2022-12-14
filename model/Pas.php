<?php


class Pas
{
    public $id;
    public $ime;
    public $godine;
    public $boja;
    public $tezina;

    public function __construct($id = null, $ime = null, $godine = null, $boja = null, $tezina = null)
    {
        $this->id = $id;
        $this->ime = $ime;
        $this->godine = $godine;
        $this->boja = $boja;
        $this->tezina = $tezina;
    }


    public static function getAll($conn)
    {
        $query = "SELECT * FROM psi";
        return $conn->query($query);
    }

    public static function getAllUnadopted($conn)
    {
        $query = "SELECT p.id, p.ime FROM psi AS p
                    LEFT JOIN ugovori AS ug ON ug.pas_id = p.id WHERE ug.id IS NULL";
        return $conn->query($query);
    }

    public static function deleteById($pasID, mysqli $conn)
    {
        $q = "DELETE FROM psi WHERE id=$pasID";
        return $conn->query($q);
    }

    public static function add($ime, $godine, $boja, $tezina, mysqli $conn)
    {
        $q = "INSERT INTO psi(ime, godine, boja, tezina) values('$ime', '$godine', '$boja', '$tezina')";
        return $conn->query($q);
    }

    public static function update($id, $ime, $godine, $boja, $tezina, mysqli $conn)
    {
        $q = "UPDATE psi set ime = '$ime', godine = '$godine', boja ='$boja', tezina = '$tezina' where id = $id";
        return $conn->query($q);
    }

    public static function getById($id, mysqli $conn)
    {
        $q = "SELECT * FROM psi WHERE id = $id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function getLast(mysqli $conn)
    {
        $q = "SELECT * FROM psi ORDER BY id DESC LIMIT 1";
        return $conn->query($q);
    }

}