<?php


class Ugovor
{
    public $id;
    public $potpisano;
    public $datumPotpisa;
    public $pasId;
    public $udomiteljId;

    public function __construct($id = null, $potpisano = null, $datumPotpisa = null, $pasId = null, $udomiteljId = null)
    {
        $this->id = $id;
        $this->potpisano = $potpisano;
        $this->datumPotpisa = $datumPotpisa;
        $this->pasId = $pasId;
        $this->udomiteljId = $udomiteljId;
    }


    public static function getAll($conn)
    {
        $query = "SELECT u.id, u.pas_id, u.udomitelj_id, u.potpisano, u.datum_potpisa, p.ime as ime_psa, ud.ime as ime_udomitelja FROM ugovori AS u
                    LEFT JOIN psi AS p ON u.pas_id = p.id
                    LEFT JOIN udomitelji AS ud ON u.udomitelj_id = ud.id";
        return $conn->query($query);
    }

    public static function deleteById($id, mysqli $conn)
    {
        $q = "DELETE FROM ugovori WHERE id = $id";
        return $conn->query($q);
    }

    public static function add($potpisano, $datumPotpisa, $pasId, $udomiteljId, mysqli $conn)
    {
        $q = "INSERT INTO ugovori(potpisano, datum_potpisa, pas_id, udomitelj_id) values('$potpisano', '$datumPotpisa', '$pasId', '$udomiteljId')";
        return $conn->query($q);
    }

    public static function update($id, $potpisano, $datumPotpisa, $pasId, $udomiteljId, mysqli $conn)
    {
        $q = "UPDATE ugovori set potpisano = '$potpisano', datum_potpisa = '$datumPotpisa', pas_id = '$pasId', udomitelj_id = '$udomiteljId' where id = $id";
        return $conn->query($q);
    }

    public static function getById($id, mysqli $conn)
    {
        $q = "SELECT u.id, u.pas_id, u.udomitelj_id, u.potpisano, u.datum_potpisa, p.ime as ime_psa, ud.ime as ime_udomitelja FROM ugovori AS u
                    LEFT JOIN psi AS p ON u.pas_id = p.id
                    LEFT JOIN udomitelji AS ud ON u.udomitelj_id = ud.id WHERE u.id = $id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $row['datum_potpisa'] = date('m/d/Y', strtotime($row['datum_potpisa']));
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function getByPasId($id, mysqli $conn)
    {
        $q = "SELECT * FROM ugovori WHERE pas_id = $id";
        $myArray = array();
        if ($result = $conn->query($q)) {

            while ($row = $result->fetch_array(1)) {
                $row['datum_potpisa'] = date('Y-m-d', strtotime($row['datum_potpisa']));
                $myArray[] = $row;
            }
        }
        return $myArray;
    }

    public static function getLast(mysqli $conn)
    {
        $q = "SELECT u.id, u.pas_id, u.udomitelj_id, u.potpisano, u.datum_potpisa, p.ime as ime_psa, ud.ime as ime_udomitelja FROM ugovori AS u
                    LEFT JOIN psi AS p ON u.pas_id = p.id
                    LEFT JOIN udomitelji AS ud ON u.udomitelj_id = ud.id ORDER BY u.id DESC LIMIT 1";
        return $conn->query($q);
    }
}