<?php
include_once("assets/php/funkcije.php");

$odg = "";

if(isset($_SESSION["status"])) {
    header("location: index.php");
    die();
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

    $odg = dodaj_korisnika($ime,$prezime,$lozinka,$potvrda,$pol,$mesto_rodjenja,$drzava_rodjenja,$datum_rodjenja,$jmbg,$telefon,$email,$slika,$status);
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

<div class="main">


    <form class="registracija" method="post" action="register.php" enctype="multipart/form-data">
        <h2>registrujte se</h2>

        <?php echo $odg; ?>

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
</div>

<div class="footer">
    <?php include_once("assets/php/footer.php"); ?>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
