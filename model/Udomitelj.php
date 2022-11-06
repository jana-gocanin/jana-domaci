<?php


class Udomitelj
{
    public $id;
    public $ime;
    public $prezime;
    public $datumRodjenja;
    public $email;

    public function __construct($id = null, $ime = null, $prezime = null, $datumRodjenja = null, $email = null)
    {
        $this->id = $id;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->datumRodjenja = $datumRodjenja;
        $this->email = $email;
    }


    public static function getAll($conn)
    {
        $query = "SELECT * FROM udomitelji";
        return $conn->query($query);
    }

    public static function deleteById($id, mysqli $conn)
    {
        $q = "DELETE FROM udomitelji WHERE id = $id";
        return $conn->query($q);
    }

    public static function add($ime, $prezime, $datumRodjenja, $email, mysqli $conn)
    {
        $q = "INSERT INTO udomitelji(ime, prezime, datum_rodjenja, email) values('$ime', '$prezime', '$datumRodjenja', '$email')";
        return $conn->query($q);
    }

    public static function update($id,$ime, $prezime, $datumRodjenja, $email, mysqli $conn)
    {
        $q = "UPDATE udomitelji set ime = '$ime', prezime = '$prezime', datum_rodjenja ='$datumRodjenja', email = '$email' where id = $id";
        return $conn->query($q);
    }

    public static function getById($id, mysqli $conn)
    {
        $q = "SELECT * FROM udomitelji WHERE id = $id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

}