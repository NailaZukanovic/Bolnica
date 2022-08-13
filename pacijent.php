<?php
include_once("assets/php/funkcije.php");

$odg = "";

$odabranLekar = false;

if(!isset($_SESSION["status"]) || $_SESSION["status"]!="pacijent"){
    header("location: index.php");
    die();
}

if(isset($_POST["promenaLozinka"])){
    $staraLozinka = $_POST["staraLozinka"];
    $novaLozinka = $_POST["novaLozinka"];
    $potvrdaLozinka = $_POST["potvrdaLozinka"];

    $odg = promeni_lozinku($staraLozinka,$novaLozinka,$potvrdaLozinka);
}

if(isset($_POST["promeniLekara"])){
    $lekar_id = $_POST["lekar"];
    $pacijent_id = $_SESSION["korisnik"]["id"];

    set("DELETE FROM promena_lekara WHERE id_pacijent=".$pacijent_id);

    if(set("INSERT INTO promena_lekara VALUES(NULL,".$pacijent_id.",".$lekar_id.")")){
        $odg = success("zahtev za promenu poslat");
    }else{
        $odg = danger("greska");
    }
}

if(isset($_POST["odaberiLekara"])){
    $lekar_id = $_POST["lekar"];
    $pacijent_id = $_SESSION["korisnik"]["id"];

    if(set("INSERT INTO izabrani_lekar VALUES(NULL,".$lekar_id.",".$pacijent_id.")")){
        $odg = success("uspesan zibor lekara");
    }else{
        $odg = danger("greska");
    }
}

if(isset($_POST["zakazi"])){
    $datum = $_POST["datum"];
    $usluga_id = $_POST["usluga"];
    $id_pacijent = $_SESSION["korisnik"]["id"];
    $dodatno = $_POST["dodatno"];

    set("INSERT INTO termini VALUES (NULL,".$usluga_id.",".$id_pacijent.",'".$datum."','".$dodatno."')");
    $odg = success("uspesno zakazano");
}

if(isset($_POST["posalji"])){
    $id_lekar = $_POST["id_lekar"];
    $poruka = $_POST["poruka"];
    $id_pacijent = $_SESSION["korisnik"]["id"];
    $poslao = "pacijent";

    posalji_poruku($id_lekar,$id_pacijent,$poslao,$poruka);
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

<div class="pacijent">

    <div class="meni text-center">
        <ul>
            <?php
                //da li pacijent ima izabranog lekara
                $result = get("SELECT * FROM izabrani_lekar WHERE id_pacijent=".$_SESSION["korisnik"]["id"]);
                if($result->num_rows===0){
                    //nema izabranog lekara
                    ?>
                        <li>
                            <a href="?izborLekara">izbor lekara</a>
                        </li>
                    <?php
                }else{
                    //ima izabranog lekara
                    $odabranLekar = true;
                    ?>
                        <li>
                            <a href="?promenaLekara">promena lekara</a>
                        </li>
                        <li>
                            <a href="?zakazi_uslugu">zakazivanje usluge</a>
                        </li>
                        <li>
                            <a href="?poruke">poruke</a>
                        </li>
                        <li>
                            <a href="?karton">karton</a>
                        </li>
                    <?php
                }
            ?>

            <li>
                <a href="?promenaLozinka">promena lozinke</a>
            </li>
        </ul>

        <?php echo $odg; ?>

        <?php
            if(isset($_GET["promenaLozinka"])){
                ?>
                    <h3>promena lozinke</h3>

                    <form class="promenaLozinka" method="post" action="pacijent.php?promenaLozinka">

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

            if(isset($_GET["izborLekara"]) && $odabranLekar==false){
                ?>
                    <h3>odabir lekara</h3>

                    <form class="promenaLozinka" method="post" action="pacijent.php?izborLekara">
                        <div>
                            <?php
                                $lekari = get("SELECT * FROM korisnik WHERE status='lekar' AND status_odobrenja='odobren'");
                            ?>
                            <label for="lekar">lekari</label>
                            <select name="lekar" id="lekar" class="form-select">
                                <?php
                                    while ($lekar = $lekari->fetch_assoc()){
                                        ?>
                                            <option value="<?php echo $lekar["id"]; ?>"><?php echo $lekar["korime"]; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div>
                            <button type="submit" name="odaberiLekara" id="odaberiLekara" class="btn btn-success">
                                odaberi
                            </button>
                        </div>
                    </form>
                <?php
            }

            if(isset($_GET["promenaLekara"])){
                $id_lekar = get("SELECT * FROM izabrani_lekar WHERE id_pacijent=".$_SESSION["korisnik"]["id"])->fetch_assoc()["id_lekar"];
                $lekar = get("SELECT * FROM korisnik WHERE id=".$id_lekar." AND status='lekar'")->fetch_assoc();
                ?>

                <h3>Odabrani lekar <small>"<?php echo $lekar["korime"];?></small>"</h3>

                <form class="promenaLozinka" method="post" action="pacijent.php?promenaLekara">
                    <div>
                        <?php
                        $lekari = get("SELECT * FROM korisnik WHERE status='lekar' AND status_odobrenja='odobren' AND id!=".$id_lekar);
                        ?>
                        <label for="lekar">lekari</label>
                        <select name="lekar" id="lekar" class="form-select">
                            <?php
                            while ($lekar = $lekari->fetch_assoc()){
                                ?>
                                <option value="<?php echo $lekar["id"]; ?>"><?php echo $lekar["korime"]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <button type="submit" name="promeniLekara" id="promeniLekara" class="btn btn-success">
                            promeni
                        </button>
                    </div>
                </form>

                <?php
            }

            if(isset($_GET["zakazi_uslugu"])){
                $usluge = get("SELECT * FROM stomatoloske_usluge");

                ?>

                <form action="pacijent.php?zakazi_uslugu" method="post" class="promenaLozinka">
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

            if(isset($_GET["poruke"])){
                $lekar_id = get("SELECT * FROM izabrani_lekar WHERE id_pacijent=".$_SESSION["korisnik"]["id"])->fetch_assoc()["id_lekar"];
                $pacijent_id = $_SESSION["korisnik"]["id"];

                $poruke = get("SELECT * FROM poruke WHERE id_lekar=".$lekar_id." AND id_pacijent=".$pacijent_id);
                ?>
                    <div class="pacijent_poruke" id="pacijent_poruke">

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
                    <form method="post" class="promenaLozinka" action="pacijent.php?poruke">
                        <input type="hidden" name="id_lekar" value="<?php echo $lekar_id; ?>">
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

            if(isset($_GET["karton"])){
                ?>
                    <h3>karton</h3>
                    <hr>
                <?php

                $podaci = get("
                    SELECT * 
                    FROM termini,stomatoloske_usluge,korisnik
                    WHERE termini.id_usluga = stomatoloske_usluge.id AND 
                    termini.id_pacijent = korisnik.id AND 
                    korisnik.id=".$_SESSION["korisnik"]["id"]."
                ");

                while ($poruka = $podaci->fetch_assoc()){
                    ?>
                        <h4><?php echo $poruka["naziv"]; ?></h4>
                        <p><?php echo $poruka["datum"]; ?></p>
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
