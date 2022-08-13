<?php
include_once("assets/php/funkcije.php");

$odg = "";

if(!isset($_SESSION["status"]) || $_SESSION["status"]!="lekar"){
    header("location: index.php");
    die();
}

if(isset($_POST["promenaLozinka"])){
    $staraLozinka = $_POST["staraLozinka"];
    $novaLozinka = $_POST["novaLozinka"];
    $potvrdaLozinka = $_POST["potvrdaLozinka"];

    $odg = promeni_lozinku($staraLozinka,$novaLozinka,$potvrdaLozinka);
}

if(isset($_POST["objavi"])){
    $naslov = $_POST["naslov"];
    $tekst = $_POST["tekst"];
    $tip = $_POST["tip"];

    set("INSERT INTO novosti VALUES(NULL,'".$tip."','".$naslov."','".$tekst."',now(),".$_SESSION["korisnik"]["id"].")");

    $odg = success("uspesna objava");
}

if(isset($_POST["posalji"])){
    $id_pacijent = $_POST["id_pacijent"];
    $poruka = $_POST["poruka"];
    $id_lekar = $_SESSION["korisnik"]["id"];
    $poslao = "lekar";

    posalji_poruku($id_lekar,$id_pacijent,$poslao,$poruka);
}

if(isset($_POST["zakazi"])){
    $datum = $_POST["datum"];
    $usluga_id = $_POST["usluga"];
    $id_pacijent = $_POST["pacijent"];
    $dodatno = $_POST["dodatno"];

    set("INSERT INTO termini VALUES (NULL,".$usluga_id.",".$id_pacijent.",'".$datum."','".$dodatno."')");
    $odg = success("uspesno zakazano");
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

<div class="lekar">

    <div class="meni text-center">
        <ul>

            <li>
                <a href="?promenaLozinka">promena lozinke</a>
            </li>
            <li>
                <a href="?pregledPacijenti">pregled pacijenata</a>
            </li>
            <li>
                <a href="?objava">napravi objavu</a>
            </li>
            <li>
                <a href="?zakazi_uslugu">zakazivanje usluge</a>
            </li>
            <li>
                <a href="?raspored">raspored</a>
            </li>
        </ul>

        <?php echo $odg; ?>

        <?php
        if(isset($_GET["promenaLozinka"])){
        ?>
        <h3>promena lozinke</h3>

        <form class="promenaLozinka" method="post" action="lekar.php?promenaLozinka">

            <div>
                <label for="staraLozinka">stara lozinka</label>
                <input class="form-control" type="password" name="staraLozinka" id="staraLozinka">
            </div>

            <div>
                <label for="novaLozinka">nova lozinka</label>
                <input class="form-control" type="password" name="novaLozinka" id="novaLozinka">
            </div>

            <div>
                <label for="potvrdaLozinka">potvrda lozinke</label>
                <input class="form-control" type="password" name="potvrdaLozinka" id="potvrdaLozinka">
            </div>

            <div>
                <button type="submit" name="promenaLozinka" id="promenaLozinka" class="btn btn-success">
                    Promeni lozinku
                </button>
            </div>
        </form>
        <?php
            }

        if(isset($_GET["pregledPacijenti"])){
            $pacijenti = get("
                SELECT * 
                FROM izabrani_lekar,korisnik
                WHERE izabrani_lekar.id_pacijent = korisnik.id AND 
                izabrani_lekar.id_lekar=".$_SESSION["korisnik"]["id"]."
            ");

        ?>

        <h3>pacijenti</h3>

        <?php
            while ($pacijent = $pacijenti->fetch_assoc()){
                ?>
                    <p>
                        Ime: <?php echo $pacijent["ime"]; ?><br>
                        Prezime: <?php echo $pacijent["prezime"]; ?><br>
                        Korisnicko ime: <?php echo $pacijent["korime"]; ?><br>
                        Pol: <?php echo $pacijent["pol"]; ?><br>
                        mesto rodjenja: <?php echo $pacijent["mesto_rodjenja"]; ?><br>
                        Drzava rodjenja: <?php echo $pacijent["drzava_rodjenja"]; ?><br>
                        Datum rodjenja: <?php echo $pacijent["datum_rodjenja"]; ?><br>
                        telefon: <?php echo $pacijent["telefon"]; ?><br>
                        email: <?php echo $pacijent["email"]; ?><br>
                        <a href="?poruka=<?php echo $pacijent["id"]; ?>">
                            poruka
                        <hr>
                    </p>
                <?php
            }

        }

        if(isset($_GET["zakazi_uslugu"])){
            $usluge = get("SELECT * FROM stomatoloske_usluge");
            $pacijenti = get("
                SELECT * FROM izabrani_lekar,korisnik
                WHERE korisnik.id=izabrani_lekar.id_pacijent AND 
                izabrani_lekar.id_lekar=".$_SESSION["korisnik"]["id"]."
            ");

            ?>

            <form action="lekar.php?zakazi_uslugu" method="post" class="promenaLozinka">
                <div>
                    <label for="usluga">odaberite uslugu</label>
                    <select id="usluga" class="form-select" name="usluga">
                        <?php
                        while ($usluga = $usluge->fetch_assoc()){
                            ?>
                            <option value="<?php echo $usluga["id"]; ?>">
                                <?php echo $usluga["naziv"]; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <label for="pacijent">odaberite pacijenta</label>
                    <select id="pacijent" class="form-select" name="pacijent">
                        <?php
                        while ($pacijent = $pacijenti->fetch_assoc()){
                            ?>
                            <option value="<?php echo $pacijent["id"]; ?>">
                                <?php echo $pacijent["korime"]; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <div>
                        <label for="datum">datum</label>
                        <input type="date" name="datum" value="datum" class="form-control">
                    </div>

                    <div>
                        <label for="dodatno">dodatni podaci za uslugu</label>
                        <textarea class="form-control" name="dodatno" id="dodatno"></textarea>
                    </div>

                    <div>
                        <button class="btn btn-success" name="zakazi" type="submit">
                            zakazi
                        </button>
                    </div>
                </div>
            </form>

            <?php
        }

        if(isset($_GET["raspored"])){
            ?>
                <h3>Raspored</h3>
            <?php
            $raspored = get("
                SELECT * 
                FROM stomatoloske_usluge,termini,korisnik,izabrani_lekar
                WHERE termini.id_usluga = stomatoloske_usluge.id AND 
                      termini.id_pacijent = korisnik.id AND 
                      izabrani_lekar.id_pacijent = termini.id_pacijent AND 
                      izabrani_lekar.id_lekar = ".$_SESSION["korisnik"]["id"]."
            ");

            while ($row = $raspored->fetch_assoc()){
                ?>
                    <div class="osoblje mx-auto">
                        <p>ime pacijenta: <?php echo $row["ime"]; ?></p>
                        <p>prezime pacijenta: <?php echo $row["prezime"]; ?></p>
                        <p>usluga: <?php echo $row["naziv"]; ?></p>
                        <p>datum: <?php echo $row["datum"]; ?></p>
                        <hr>
                        <p>dodatni podaci: <br><?php echo $row["dodatni_podaci"]; ?></p>
                    </div>
                <?php
            }
        }

        if(isset($_GET["objava"])){
            ?>
            <form class="promenaLozinka" method="post" action="lekar.php?objava">
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

        if(isset($_GET["poruka"])){
            $lekar_id = $_SESSION["korisnik"]["id"];
            $pacijent_id = $_GET["poruka"];

            $poruke = get("SELECT * FROM poruke WHERE id_lekar=".$lekar_id." AND id_pacijent=".$pacijent_id);
            ?>
            <div class="lekar_poruke" id="pacijent_poruke">

                <?php
                while ($poruka = $poruke->fetch_assoc()){
                    ?>
                    <p class="poslao<?php echo $poruka["poslao"];?>">
                        <?php echo $poruka["poruka"];?>
                        <br>
                        <br>
                        <small><?php echo $poruka["vreme"];?></small>
                    </p>
                    <?php
                }
                ?>

            </div>
            <form method="post" class="promenaLozinka" action="lekar.php?poruka=<?php echo $_GET["poruka"]; ?>">
                <input type="hidden" name="id_pacijent" value="<?php echo $pacijent_id; ?>">
                <div>
                    <label for="poruka">poruka</label>
                    <textarea class="form-control" name="poruka" id="poruka"></textarea>
                </div>
                <div>
                    <button class="btn btn-success" type="submit" name="posalji">
                        posalji
                    </button>
                </div>
            </form>
            <?php
        }

        ?>


</div>

<div class="footer">
    <?php include_once("assets/php/footer.php"); ?>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
