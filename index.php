<?php
include_once("assets/php/funkcije.php");

$odg = "";

if(isset($_SESSION["status"]) && $_SESSION["status"]=="admin" && isset($_POST["obrisiObajvu"])){
    set("DELETE FROM novosti WHERE id=".$_POST["obrisiObajvu"]);
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

        <div class="pocetna">

            <ul class="usluge">
                <li><b>Nase usluge</b></li>
                <?php
                    $usluge = get("SELECT * FROM stomatoloske_usluge");
                    while ($usluga = $usluge->fetch_assoc()){
                        ?>
                            <li><?php echo $usluga["naziv"]; ?></li>
                        <?php
                    }
                ?>
            </ul>



            <?php
                if(isset($_GET["tip"])){
                    $objave = get("SELECT * FROM novosti WHERE tip='".$_GET["tip"]."'");
                }else{
                    $objave = get("SELECT * FROM novosti");
                }

                while ($objava = $objave->fetch_assoc()){
                    ?>
                        <div class="objava">
                            <a href="index.php?tip=<?php echo $objava["tip"]; ?>">
                                <?php echo $objava["tip"]; ?>
                            </a>

                            <h2><?php echo $objava["naslov"]; ?></h2>

                            <p><?php echo $objava["tekst"]; ?></p>

                            <small><?php echo $objava["datum_objave"]; ?></small>

                            <?php
                                if(isset($_SESSION["status"]) && $_SESSION["status"]=="admin"){
                                    ?>
                                        <form action="index.php" method="post">
                                            <button type="submit" name="obrisiObajvu" class="btn btn-danger" value="<?php echo $objava["id"]; ?>">
                                                ukloni
                                            </button>
                                        </form>
                                    <?php
                                }
                            ?>

                        </div>
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
