<?php
include_once("assets/php/funkcije.php");

$odg = "";

if(isset($_SESSION["status"]) && $_SESSION["status"]=="admin" && isset($_POST["obrisi"])){
    $id = $_POST["obrisi"];

    set("DELETE FROM slike WHERE id=".$id);
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

<div class="galerija">
    <?php
        $slike = get("SELECT * FROM slike");
        while ($slika = $slike->fetch_assoc()){
            ?>
                <div class="img-holder">
                    <img src="assets/img/<?php echo $slika["ime"]; ?>">

                    <?php
                        if(isset($_SESSION["status"]) && $_SESSION["status"]=="admin"){
                            ?>
                                <form class="registracija" method="post" action="galerija.php">
                                    <button class="btn btn-danger" type="submit" name="obrisi" value="<?php echo $slika["id"]; ?>">
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
