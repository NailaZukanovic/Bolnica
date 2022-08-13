<?php
include_once("assets/php/funkcije.php");

$odg = "";

if(!isset($_SESSION["status"]) || $_SESSION["status"]!="admin"){
    header("location: index.php");
    die();
}

if(isset($_POST["odobri"])){
    $id = $_POST["odobri"];
    set("UPDATE korisnik SET status_odobrenja='odobren' WHERE id=".$id);
    $odg = success("korisnik uspesno odobren");
}

if(isset($_POST["ukloni"])){
    $id = $_POST["ukloni"];
    set("DELETE FROM korisnik WHERE id=".$id);
    $odg = success("korisnik uspesno uklonjen");
}

if(isset($_POST["registruj"])){
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $lozinka = $_POST["lozinka"];
    $potvrda = $_POST["potvrda"];
    $pol = $_POST["pol"];
    $mesto_rodjenja = $_POST["mesto"];
    $drzava_rodjenja = $_POST["drzava"];
    $datum_rodjenja = $_POST["datum"];
    $jmbg = $_POST["jmbg"];
    $telefon = $_POST["telefon"];
    $email = $_POST["email"];
    $slika = $_FILES["slika"];
    $status = $_POST["status"];

    $odg = dodaj_korisnika($ime,$prezime,$lozinka,$potvrda,$pol,$mesto_rodjenja,$drzava_rodjenja,$datum_rodjenja,$jmbg,$telefon,$email,$slika,$status,"odobren");
}

if(isset($_POST["odbijPromenuLekara"])){
    $id = $_POST["odbijPromenuLekara"];
    set("DELETE FROM promena_lekara WHERE id=".$id);
    $odg = success("zahtev odbijen");
}

if(isset($_POST["odobriPromenuLekara"])){
    $id = $_POST["odobriPromenuLekara"];

    $podaci = get("SELECT * FROM promena_lekara WHERE id=".$id)->fetch_assoc();

    $id_pacijent = $podaci["id_pacijent"];
    $id_novi_lekar = $podaci["id_novi_lekar"];

    set("UPDATE izabrani_lekar SET id_lekar=".$id_novi_lekar." WHERE id_pacijent=".$id_pacijent);
    set("DELETE FROM promena_lekara WHERE id=".$id);

    $odg = success("uspesna izmena");
}

if(isset($_POST["objavi"])){
    $naslov = $_POST["naslov"];
    $tekst = $_POST["tekst"];
    $tip = $_POST["tip"];

    set("INSERT INTO novosti VALUES(NULL,'".$tip."','".$naslov."','".$tekst."',now(),".$_SESSION["korisnik"]["id"].")");

    $odg = success("uspesna objava");
}

if(isset($_POST["dodajSliku"])){
    $slika = $_FILES["slika"];
    if(dodaj_sliku($slika)){
        set("INSERT INTO slike VALUES(NULL,'".$slika["name"]."')");
        $odg = success("slika dodata");
    }else{
        $odg = danger("greska");
    }
}

?>

<html>
<head>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="navigacija">
    <?php include_once("assets/php/navigacija.php"); ?>
</div>

<div class="admin">

    <div class="text-center">
        <?php echo $odg; ?>
    </div>

    <div class="left">
        <ul>

            <li>
                <?php
                    $broj = get("SELECT count(*) AS broj FROM korisnik WHERE status_odobrenja='cekanje'")->fetch_assoc();
                ?>
                <a href="?noviKorisnici">Novi korisnici (<?php echo $broj["broj"]; ?>)</a>
            </li>
            <li><a href="?dodaj_korisnika">dodaj korisnika</a></li>
            <li>
                <a href="?objava">napravi objavu</a>
            </li>
            <li>
                <a href="?slika">dodaj sliku</a>
            </li>
            <li>
                <?php
                    $broj = get("SELECT count(*) AS broj FROM korisnik WHERE status_odobrenja='odobren' AND status!='admin'")->fetch_assoc();
                ?>
                <a href="?korisnici">korisnici (<?php echo $broj["broj"]; ?>)</a>
            </li>
            <li>
                <?php
                $broj = get("SELECT count(*) AS broj FROM promena_lekara")->fetch_assoc();
                ?>
                <li><a href="?promena_lekara">promena lekara (<?php echo $broj["broj"]; ?>)</a></li>
            </li>
        </ul>
    </div>
    <div class="right text-center">

        <?php

        if(isset($_GET["objava"])){
            ?>
            <form class="promenaLozinka" method="post" action="admin.php?objava">
                <h3>napravite objavu</h3>

                <div>
                    <label for="staraLozinka">naslov</label>
                    <input class="form-control" type="text" name="naslov" id="naslov">
                </div>

                <div>
                    <label for="tekst">tekst</label>
                    <textarea name="tekst" id="tekst" class="form-control"></textarea>
                </div>

                <div>
                    <label for="tip">tip</label>
                    <select name="tip" id="tip" class="form-select">
                        <option value="obavestenje">obavestenje</option>
                        <option value="preporuka">preporuka</option>
                        <option value="zanimljivost">zanimljivost</option>
                    </select>
                </div>

                <div>
                    <button type="submit" name="objavi" id="objavi" class="btn btn-success">
                        objavi
                    </button>
                </div>
            </form>
            <?php
        }

        if(isset($_GET["slika"])){
            ?>
                <form class="dodavanjeSlike mx-auto" action="admin.php?slika" method="post" enctype="multipart/form-data">
                    <input type="file" name="slika" id="slika" class="form-control">
                    <button type="submit" name="dodajSliku" class="btn btn-success">
                        dodaj
                    </button>
                </form>
            <?php
        }

        if(isset($_GET["noviKorisnici"])){
            $korisnici = get("SELECT * FROM korisnik WHERE status_odobrenja='cekanje'");
            ?>
                <h3 class="d-block">Novi korisnici</h3>

                <table>
                    <tr>
                        <th><b>id</b></th>
                        <th><b>ime</b></th>
                        <th><b>prezime</b></th>
                        <th><b>korisnicko ime</b></th>
                        <th><b>pol</b></th>
                        <th><b>mesto rodjenja</b></th>
                        <th><b>drzava rodjenja</b></th>
                        <th><b>datum rodjenja</b></th>
                        <th><b>jmbg</b></th>
                        <th><b>telefon</b></th>
                        <th><b>email</b></th>
                        <th><b>status</b></th>
                        <th></th>
                        <th></th>
                    </tr>

                    <?php
                        while ($korisnik = $korisnici->fetch_assoc()){
                            ?>
                                <tr>
                                    <tr>
                                        <td><b><?php echo $korisnik["id"]; ?></b></td>
                                        <td><b><?php echo $korisnik["ime"]; ?></b></td>
                                        <td><b><?php echo $korisnik["prezime"]; ?></b></td>
                                        <td><b><?php echo $korisnik["korime"]; ?></b></td>
                                        <td><b><?php echo $korisnik["pol"]; ?></b></td>
                                        <td><b><?php echo $korisnik["mesto_rodjenja"]; ?></b></td>
                                        <td><b><?php echo $korisnik["drzava_rodjenja"]; ?></b></td>
                                        <td><b><?php echo $korisnik["datum_rodjenja"]; ?></b></td>
                                        <td><b><?php echo $korisnik["jmbg"]; ?></b></td>
                                        <td><b><?php echo $korisnik["telefon"]; ?></b></td>
                                        <td><b><?php echo $korisnik["email"]; ?></b></td>
                                        <td><b><?php echo $korisnik["status"]; ?></b></td>
                                        <td>
                                            <form action="admin.php?noviKorisnici" method="post">
                                                <button class="btn btn-success" type="submit" name="odobri" value="<?php echo $korisnik["id"]; ?>">
                                                    odobri
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="admin.php?noviKorisnici" method="post">
                                                <button class="btn btn-danger" type="submit" name="ukloni" value="<?php echo $korisnik["id"]; ?>">
                                                    ukloni
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </tr>
                            <?php
                        }
                    ?>
                </table>

            <?php
        }

        if(isset($_GET["dodaj_korisnika"])){
            ?>

                <form class="registracija" method="post" action="admin.php?dodaj_korisnika" enctype="multipart/form-data">
                    <h3 class="d-block">dodavanje korisnika</h3>

                    <div>
                        <label for="ime">Ime</label>
                        <input class="form-control" type="text" name="ime" id="ime">
                    </div>
                    <div>
                        <label for="prezime">prezime</label>
                        <input class="form-control" type="text" name="prezime" id="prezime">
                    </div>
                    <div>
                        <label for="lozinka">lozinka</label>
                        <input class="form-control" type="password" name="lozinka" id="lozinka">
                    </div>
                    <div>
                        <label for="potvrda">potvrda</label>
                        <input class="form-control" type="password" name="potvrda" id="potvrda">
                    </div>
                    <div>
                        pol:
                        <br><input type="radio" checked name="pol" value="musko"> musko
                        <br><input type="radio" name="pol" value="zensko"> zensko
                    </div>
                    <div>
                        <label for="mesto">mesto rodjenja</label>
                        <input class="form-control" type="text" name="mesto" id="mesto">
                    </div>
                    <div>
                        <label for="drzava">drzava rodjenja</label>
                        <select name="drzava" id="drzava" class="form-select">
                            <option value="srbija">srbija</option>
                            <option value="slovenija">slovenija</option>
                            <option value="crna gora">crna gora</option>
                            <option value="bih">bih</option>
                        </select>
                    </div>
                    <div>
                        <label for="datum">datum rodjenja</label>
                        <input class="form-control" type="date" name="datum" id="datum">
                    </div>
                    <div>
                        <label for="jmbg">jmbg</label>
                        <input class="form-control" type="text" name="jmbg" id="jmbg">
                    </div>
                    <div>
                        <label for="telefon">telefon</label>
                        <input class="form-control" type="tel" name="telefon" id="telefon">
                    </div>
                    <div>
                        <label for="email">email</label>
                        <input class="form-control" type="email" name="email" id="email">
                    </div>
                    <div>
                        <label for="slika">slika</label>
                        <input class="form-control" type="file" name="slika" id="slika">
                    </div>
                    <div>
                        zaduzenje:
                        <br><input type="radio" checked name="status" value="pacijent"> pacijent
                        <br><input type="radio" name="status" value="lekar"> lekar
                    </div>
                    <div>
                        <button type="submit" name="registruj" id="registruj" class="btn btn-success">
                            registruj
                        </button>
                    </div>
                </form>
            <?php
        }

        if(isset($_GET["korisnici"])){
            $korisnici = get("SELECT * FROM korisnik WHERE status_odobrenja='odobren' AND status!='admin'");
            ?>
            <h3 class="d-block">Odobreni korisnici</h3>

            <table>
                <tr>
                    <th><b>id</b></th>
                    <th><b>ime</b></th>
                    <th><b>prezime</b></th>
                    <th><b>korisnicko ime</b></th>
                    <th><b>pol</b></th>
                    <th><b>mesto rodjenja</b></th>
                    <th><b>drzava rodjenja</b></th>
                    <th><b>datum rodjenja</b></th>
                    <th><b>jmbg</b></th>
                    <th><b>telefon</b></th>
                    <th><b>email</b></th>
                    <th><b>status</b></th>
                    <th></th>
                </tr>

                <?php
                while ($korisnik = $korisnici->fetch_assoc()){
                    ?>
                    <tr>
                    <tr>
                        <td><b><?php echo $korisnik["id"]; ?></b></td>
                        <td><b><?php echo $korisnik["ime"]; ?></b></td>
                        <td><b><?php echo $korisnik["prezime"]; ?></b></td>
                        <td><b><?php echo $korisnik["korime"]; ?></b></td>
                        <td><b><?php echo $korisnik["pol"]; ?></b></td>
                        <td><b><?php echo $korisnik["mesto_rodjenja"]; ?></b></td>
                        <td><b><?php echo $korisnik["drzava_rodjenja"]; ?></b></td>
                        <td><b><?php echo $korisnik["datum_rodjenja"]; ?></b></td>
                        <td><b><?php echo $korisnik["jmbg"]; ?></b></td>
                        <td><b><?php echo $korisnik["telefon"]; ?></b></td>
                        <td><b><?php echo $korisnik["email"]; ?></b></td>
                        <td><b><?php echo $korisnik["status"]; ?></b></td>
                        <td>
                            <form action="admin.php?korisnici" method="post">
                                <button class="btn btn-danger ukloni_odobren" type="submit" name="ukloni" value="<?php echo $korisnik["id"]; ?>">
                                    ukloni
                                </button>
                            </form>
                        </td>
                    </tr>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <?php
        }

        if(isset($_GET["promena_lekara"])){
            $result = get("SELECT * FROM promena_lekara");
            while ($row=$result->fetch_assoc()){
                $id_pacijent = $row["id_pacijent"];
                $id_lekar_novi = $row["id_novi_lekar"];

                $pacijent = get("SELECT * FROM korisnik WHERE id=".$id_pacijent)->fetch_assoc();
                $lekar = get("SELECT * FROM korisnik WHERE id=".$id_lekar_novi)->fetch_assoc();
                ?>
                    <p>
                        Pacijent <b><?php echo $pacijent["korime"]; ?></b> trazi prelaz kod
                        lekara <b><?php echo $lekar["korime"]; ?></b>

                    </p>

                    <form class="promenaLozinka" action="admin.php?promena_lekara" method="post">
                        <button value="<?php echo $row["id"];?>" name="odbijPromenuLekara" type="submit" class="btn btn-danger">odbij</button>
                        <button value="<?php echo $row["id"];?>" name="odobriPromenuLekara" type="submit" class="btn btn-success">odobri</button>
                    </form>
                    <hr>
                <?php
            }
        }

        ?>

    </div>
</div>

<div class="footer">
    <?php include_once("assets/php/footer.php"); ?>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
