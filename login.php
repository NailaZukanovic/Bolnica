<?php
include_once("assets/php/funkcije.php");

$odg = "";

if(isset($_SESSION["status"])) {
    header("location: index.php");
    die();
}

if(isset($_POST["login"])){
    $korime = $_POST["korime"];
    $lozinka = $_POST["lozinka"];

    $odg = login($korime,$lozinka);
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


    <form class="registracija" method="post" action="login.php" enctype="multipart/form-data">
        <h2>registrujte se</h2>

        <?php echo $odg; ?>

        <div>
            <label for="korime">korisnicko ime</label>
            <input class="form-control" type="text" name="korime" id="korime">
        </div>

        <div>
            <label for="lozinka">lozinka</label>
            <input class="form-control" type="password" name="lozinka" id="lozinka">
        </div>
        <div>
            <button type="submit" name="login" id="login" class="btn btn-success">
                Ulogujte se
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
