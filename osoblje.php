<?php
include_once("assets/php/funkcije.php");

$odg = "";

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
    <?php
        $lekari = get("SELECT * FROM korisnik WHERE status='lekar' AND status_odobrenja='odobren'");
        while ($lekar = $lekari->fetch_assoc()){
            ?>
                <div class="osoblje mx-auto">
                    <h5><b><?php echo $lekar["korime"]; ?></b></h5>
                    <p>Ime: <?php echo $lekar["ime"]; ?></p>
                    <p>Prezime: <?php echo $lekar["prezime"]; ?></p>
                    <p>Telefon: <?php echo $lekar["telefon"]; ?></p>
                    <p>Email: <?php echo $lekar["email"]; ?></p>
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
