<nav>
    <ul>
        <li><a href="index.php">pocetna</a></li>
        <li><a href="osoblje.php">osoblje</a></li>
        <li><a href="kontakt.php">kontakt</a></li>
        <li><a href="galerija.php">galerija</a></li>

        <?php
            if(!isset($_SESSION["status"])){
                //neulogovan korisnik
                ?>
                <li><a href="login.php">login</a></li>
                <li><a href="register.php">register</a></li>
                <?php
            }else{
                //ulogovan korisnik
                if($_SESSION["status"]=="admin"){
                    ?>
                        <li><a href="admin.php">admin panel</a></li>
                    <?php
                }

                if($_SESSION["status"]=="lekar"){
                    ?>
                        <li><a href="lekar.php">profil</a></li>
                    <?php
                }

                if($_SESSION["status"]=="pacijent"){
                    ?>
                    <li><a href="pacijent.php">profil</a></li>
                    <?php
                }

                ?>
                <li><a href="assets/php/logout.php">logout</a></li>
                <?php
            }
        ?>
    </ul>
</nav>