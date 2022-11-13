<?php

require "dbBroker.php";
require "model/Ugovor.php";
require "model/Pas.php";
require "model/Udomitelj.php";

$ugovori = Ugovor::getAll($conn);
$psi = Pas::getAll($conn);
$udomitelji = Udomitelj::getAll($conn);
$neudomljeniPsi = Pas::getAllUnadopted($conn);


$ugoviriArray = [];
$psiArray = [];
$udomiteljiArray = [];
$neudomljeniPsiArray = [];

while ($row1 = $ugovori->fetch_array()) {
    $ugoviriArray[] = $row1;
}

while ($row2 = $psi->fetch_array()) {
    $psiArray[] = $row2;
}

while ($row3 = $udomitelji->fetch_array()) {
    $udomiteljiArray[] = $row3;
}

while ($row4 = $neudomljeniPsi->fetch_array()) {
    $neudomljeniPsiArray[] = $row4;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Azil</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center" style=" background-color: rgba(255, 182, 193, 0);">
    <div class="container">
        <h1 style="color:darkred">Azil</h1>
    </div>

    <div class="col-md-8" style="text-align:center; width:66.6%;float:left">
        <div id="pregled">
            <table id="tabela" class="table sortable table-bordered table-hover ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Potpisano</th>
                    <th scope="col">Datum potpisa</th>
                    <th scope="col">Pas</th>
                    <th scope="col">Udomitelj</th>
                    <th scope="col" class="sorttable_nosort">Select ugovor</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($ugoviriArray as $ugovor) {
                    ?>
                    <tr id="tr-<?php echo $ugovor["id"] ?>">
                        <td><?php echo $ugovor["id"] ?></td>
                        <td><?php echo $ugovor["potpisano"] ?></td>
                        <td><?php echo date("d-m-Y", strtotime($ugovor["datum_potpisa"])) ?></td>
                        <td><?php echo $ugovor["ime_psa"] ?>[<?php echo $ugovor["pas_id"] ?>]</td>
                        <td><?php echo $ugovor["ime_udomitelja"] ?>[<?php echo $ugovor["udomitelj_id"] ?>]</td>
                        <td>
                            <label class="radio-btn">
                                <input type="radio" name="checked-donut" value=<?php echo $ugovor["id"] ?>>
                                <span class="checkmark"></span>
                            </label>
                        </td>

                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-4" style="display: block; background-color: rgba(255, 255, 255, 0.4);">
        <div style="text-align:center;">
            <h3>Pregled ugovora</h3>
            <button id="btn" class="btn btn-default" onclick="prikaziUgovore()"><img src="image/view.png"
                                                                                     style="width: 25px;height: 25px;">
            </button>
        </div>

        <div style="text-align:center;">
            <h3>Pretraga ugovora</h3>

            <input type="text" id="myInput" class="btn" placeholder="Pretrazi ugovor id" onkeyup="pretrazi()">

        </div>
        <div style="text-align:center; ">
            <h3>Dodaj psa</h3>
            <button id="btn-dodaj-psa" class="btn" data-toggle="modal" data-target="#modalDodavanjePsa"><img
                        src="image/add.png" style="width: 25px;height: 25px;"></button>
        </div>
        <div style="text-align:center; ">
            <h3>Dodaj udomitelja</h3>
            <button id="btn-dodaj" class="btn" data-toggle="modal" data-target="#modalDodavanjeUdomitelja"><img
                        src="image/add.png" style="width: 25px;height: 25px;"></button>
        </div>
        <div style="text-align:center; ">
            <h3>Dodaj novi ugovor</h3>
            <button id="btn-dodaj" class="btn" data-toggle="modal" data-target="#modalDodavanjeUgovora"><img
                        src="image/add.png" style="width: 25px;height: 25px;"></button>
        </div>
        <div style="text-align:center;">
            <h3>Izmeni ugovor</h3>
            <button id="btn-izmeni-ugovor" class="btn" data-toggle="modal" data-target="#modalIzmenaUgovora"><img
                        src="image/edit.png" style="width: 25px;height: 25px;"></button>
        </div>
        <div style="text-align:center;">
            <h3>Izbrisi ugovor</h3>
            <button id="btn-izbrisi" class="btn"><img src="image/delete.png" style="width: 25px;height: 25px;"></button>
        </div>
        <div style="text-align:center;">
            <h3>Sortiraj po datumu</h3>
            <button class="btn" onclick="sortTable()"><img src="image/sort.png" style="width: 25px;height: 25px;">
            </button>
        </div>
        <br>
    </div>

    <div class="modal fade" id="modalDodavanjePsa" role="dialog">
        <div class="modal-dialog">

            <!--Sadrzaj modala-->
            <div class="modal-content" style="border: 4px solid green;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container tim-form">
                        <form method="post" id="dodaj-form-pas">
                            <h3 id="naslov" style="color: black" text-align="center">Dodavanje psa</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="ime"
                                               class="form-control" placeholder="Ime *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="godine"
                                               class="form-control" placeholder="Godine  *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="boja"
                                               class="form-control" placeholder="Boja *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="tezina"
                                               class="form-control" placeholder="Tezina *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <button id="btn-dodaj-psa" type="submit" class="btn btn-success btn-block"
                                                style="background-color: orange; border: 1px solid black;"><i
                                                    class="glyphicon glyphicon-plus"></i> Dodaj
                                        </button>
                                    </div>

                                </div>


                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            style="color: white; background-color: orange; border: 1px solid white"
                            data-dismiss="modal">Zatvori
                    </button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalDodavanjeUdomitelja" role="dialog">
        <div class="modal-dialog">

            <!--Sadrzaj modala-->
            <div class="modal-content" style="border: 4px solid green;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container tim-form">
                        <form action="#" method="post" id="dodaj-form-udomitelj">
                            <h3 id="naslov" style="color: black" text-align="center">Dodavanje udomitelja</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="ime"
                                               class="form-control" placeholder="Ime *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" style="border: 1px solid black" name="prezime"
                                               class="form-control" placeholder="Prezime  *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <input type="date" style="border: 1px solid black" name="datum_rodjenja"
                                               class="form-control" placeholder="Datum rodjenja *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" style="border: 1px solid black" name="email"
                                               class="form-control" placeholder="Email *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <button id="btnDodaj" type="submit" class="btn btn-success btn-block"
                                                style="background-color: orange; border: 1px solid black;"><i
                                                    class="glyphicon glyphicon-plus"></i> Dodaj
                                        </button>
                                    </div>

                                </div>


                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            style="color: white; background-color: orange; border: 1px solid white"
                            data-dismiss="modal">Zatvori
                    </button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalDodavanjeUgovora" role="dialog">
        <div class="modal-dialog">

            <!--Sadrzaj modala-->
            <div class="modal-content" style="border: 4px solid green;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container tim-form">
                        <form action="#" method="post" id="dodaj-form-ugovor">
                            <h3 id="naslov" style="color: black" text-align="center">Dodavanje ugovora</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="checkbox" style="border: 1px solid black" name="potpisano"
                                               class="form-control" placeholder="Potpisano *" value="1" checked/>
                                    </div>
                                    <div class="form-group">
                                        <input type="date" style="border: 1px solid black" name="datum_potpisa"
                                               class="form-control" placeholder="Datum potpisa  *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <select name="pas_id">
                                            <?php if (!empty($psi)) {
                                            foreach ($neudomljeniPsiArray as $pas) {
                                                    ?>
                                                <option value="<?php echo $pas['id'] ?>"><?php echo $pas['ime'] ?>[<?php echo $pas['id'] ?>]</option>
                                            <?php
                                                }
                                            } else {
                                               ?>
                                                <option value="null">Nema psa</option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="udomitelj_id">
                                            <?php if (!empty($udomitelji)) {
                                                foreach ($udomiteljiArray as $udomitelj) {
                                                    ?>
                                                    <option value="<?php echo $udomitelj['id'] ?>"><?php echo $udomitelj['ime'] ?>[<?php echo $udomitelj['id'] ?>]</option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="null">Nema udomitelja</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button id="btnDodaj" type="submit" class="btn btn-success btn-block"
                                                style="background-color: orange; border: 1px solid black;"><i
                                                    class="glyphicon glyphicon-plus"></i> Dodaj
                                        </button>
                                    </div>

                                </div>


                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            style="color: white; background-color: orange; border: 1px solid white"
                            data-dismiss="modal">Zatvori
                    </button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalIzmenaUgovora" role="dialog">
        <div class="modal-dialog">

            <!-- Modal sadrzaj-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container tim-form">
                        <form action="#" method="post" id="izmeni-form-ugovor">
                            <h3 style="color: black">Izmena ugovora</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="ugovor-id" type="text" name="id" class="form-control"
                                               placeholder="Id ugovora *" value="" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <input id="ugovor-potpisano" type="checkbox" name="potpisano" class="form-control"
                                               placeholder="Potpisano *" value="1" checked/>
                                    </div>
                                    <div class="form-group">
                                        <input id="ugovor-datum" type="date" name="datum_potpisa" class="form-control"
                                               placeholder="Datum potpisa *" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <select name="pas_id">
                                            <?php if (!empty($psi)) {
                                                foreach ($psiArray as $pas) {
                                                    ?>
                                                    <option id="ugovor-pas-id-<?php echo $pas['id'] ?>" value="<?php echo $pas['id'] ?>"><?php echo $pas['ime'] ?>[<?php echo $pas['id'] ?>]</option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="null">Nema psa</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="udomitelj_id">
                                            <?php if (!empty($udomitelji)) {
                                                foreach ($udomiteljiArray as $udomitelj) {
                                                    ?>
                                                    <option id="ugovor-udomitelj-id-<?php echo $udomitelj['id'] ?>" value="<?php echo $udomitelj['id'] ?>"><?php echo $udomitelj['ime'] ?>[<?php echo $udomitelj['id'] ?>]</option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="null">Nema udomitelja</option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button id="btnIzmeni" type="submit" class="btn btn-success btn-block"
                                                style="color: white; background-color: orange; border: 1px solid white">
                                            <i class="glyphicon glyphicon-pencil"></i> Izmeni
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
