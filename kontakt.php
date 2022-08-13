<?php
include_once("assets/php/funkcije.php");

$odg = "";

if(isset($_POST["izmeni"]) && isset($_SESSION["status"]) && $_SESSION["status"]=="admin"){
    $telefon = $_POST["telefon"];
    $email = $_POST["email"];

    $myfile = fopen("kontakt.txt", "w") or die("Unable to open file!");
    fwrite($myfile, $email."\n".$telefon);
    fclose($myfile);
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

<div class="kontakt text-center">

    <?php
        $handle = fopen("kontakt.txt", "r");
        $email = fgets($handle);
        $telefon = fgets($handle);
        fclose($handle);

        if(isset($_SESSION["status"]) && $_SESSION["status"]=="admin"){
            ?>
                <form class="kontaktForm mx-auto" method="post" action="kontakt.php" enctype="multipart/form-data">
                    <h2>kontakt</h2>

                    <?php echo $odg; ?>

                    <div>
                        <label for="email">email</label>
                        <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>">
                    </div>
                    <div>
                        <label for="telefon">telefon</label>
                        <input class="form-control" type="text" name="telefon" id="telefon" value="<?php echo $telefon; ?>">
                    </div>

                    <div>
                        <button type="submit" name="izmeni" id="izmeni" class="btn btn-success">
                            izmeni
                        </button>
                    </div>
                </form>
            <?php
        }else{
            ?>
                <p>Email: <?php echo $email; ?></p>
                <p>telefon: <?php echo $telefon; ?></p>
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
