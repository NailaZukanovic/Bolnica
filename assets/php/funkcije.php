<?php
session_start();

function konekcija(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "medicinska_ustanova";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        //die("Connection failed: " . $conn->connect_error);
        die("Stranica je trenutno na održavanju, molimo pokušajte kasnije, greska 1");
    }

    return $conn;
}

function get($sql){
    $conn = konekcija();
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function set($sql){
    $conn = konekcija();
    $ans = $conn->query($sql);

    if(!$ans){
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    return $ans;
}

function sanitise($string) {
    //preg_replace('/[^a-zA-Z0-9]+/', '', $text)
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function user_input($data) {
    $data = trim($data);
    $data = strip_tags($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function check_current($curr){
    $page = ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
    $page = strtolower($page);

    if($page==$curr){
        echo "active";
    }
}

function success($txt){
    return '<div class="success">
              '.$txt.'
            </div>';
}

function danger($txt){
    return '<div class="danger">
              '.$txt.'
            </div>';
}

function generate_korime($ime){
    return $ime.rand(10,10000);
}

function dodaj_korisnika($ime,$prezime,$lozinka,$potvrda,$pol,$mesto_rodjenja,$drzava_rodjenja,$datum_rodjenja,$jmbg,$telefon,$email,$slika,$status,$status_odobrenja="cekanje"){
    $ans = is_password_strong($lozinka);
    if($ans!==true){
        return $ans;
    }

    $korime = generate_korime($ime);

    $ans = set("INSERT INTO korisnik VALUES(NULL,'".$ime."','".$prezime."','".$korime."','".$lozinka."','".$pol."','".$mesto_rodjenja."','".$drzava_rodjenja."','".$datum_rodjenja."','".$jmbg."','".$telefon."','".$email."','".$slika["name"]."','".$status."','".$status_odobrenja."')");
    if($ans){
        set("INSERT INTO stare_lozinke VALUES(NULL,'".$korime."','".$lozinka."')");
        return success("korisnik uspesno dodat vase korisnicko ime je <b>".$korime."</b>");
    }else{
        return danger("greska");
    }
}

function is_password_strong($password) {
    if(strlen($password)<10){
        return danger("lozinka mora biti minimum 10 karaktera");
    }

    return true;
}

function login($korime,$lozinka) {
    $result = get("SELECT * FROM korisnik WHERE korime='".$korime."' AND lozinka='".$lozinka."'");

    if($result->num_rows===0){
        return danger("korisnik nije pronadjen");
    }

    $result = $result->fetch_assoc();

    if($result["status_odobrenja"]=="cekanje"){
        return danger("nalog vam jos uvek nije odobren");
    }

    $_SESSION["status"] = $result["status"];
    $_SESSION["korisnik"] = $result;

    header("location: index.php");
    die();
}

function promeni_lozinku($staraLozinka,$novaLozinka,$potvrdaLozinka){
    if($staraLozinka != $_SESSION["korisnik"]["lozinka"]){
        return danger("pogresno uneta stara lozinka");
    }

    if($novaLozinka!=$potvrdaLozinka){
        return danger("nova lozinka i potvrda se ne poklapaju");
    }

    //ne moze biti kao prethodna
    $result = get("SELECT * FROM stare_lozinke WHERE korime='".$_SESSION["korisnik"]["korime"]."' AND lozinka='".$novaLozinka."'");
    if($result->num_rows>0){
        return danger("ne mozete koristiti lozinku koju ste vec upotrebljavali");
    }

    set("INSERT INTO stare_lozinke VALUES(NULL,'".$_SESSION["korisnik"]["korime"]."','".$novaLozinka."')");
    set("UPDATE korisnik SET lozinka='".$novaLozinka."' WHERE korime='".$_SESSION["korisnik"]["korime"]."'");

    $_SESSION["korisnik"]["lozinka"] = $novaLozinka;

    return success("uspesna promena");
}

function posalji_poruku($id_lekar,$id_pacijent,$poslao,$poruka){
    set("INSERT INTO poruke VALUES(NULL,".$id_lekar.",".$id_pacijent.",'".$poslao."',now(),'".$poruka."')");
}

function dodaj_sliku($slika) {
    $target_dir = "assets/img/";
    $target_file = $target_dir . basename($slika["name"]);
    move_uploaded_file($slika["tmp_name"], $target_file);

    return true;
}

?>