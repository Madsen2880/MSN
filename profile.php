<?php
session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';

if($_GET){
    if(!empty($_GET["id"]) && is_numeric($_GET["id"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("SELECT 
        users.id AS user_ID, users.username, users.email,
        userDetails.firstname, userDetails.surname, userDetails.age, userDetails.gender,
        userDetails.city, userDetails.country, userDetails.profileText,
        DATE_FORMAT(userdetails.DateCreated, '%d-%m-%Y %h:%i:%s') AS dateCreated, userdetails.ProfilePictureId,
        pictures.filename AS profilePicture, pictures.title AS pictureTitle
        FROM `users` 
        INNER JOIN userdetails ON users.id = userdetails.UserId AND users.id = :ID
        INNER JOIN pictures ON userdetails.ProfilePictureId = pictures.id");
        $query->bindParam(':ID', $_GET["id"], PDO::PARAM_STR);
        if($query->execute() && $query->rowCount() > 0){
            $userDetail = $query->fetch(PDO::FETCH_ASSOC);
?>
<pre>
<?=print_r($userDetail, true)?>
</pre>
<?php
        }else{
            echo 'Bruger findes ikke';
        }
    }else{
        header('Location: ./');
    }
}

?>
<?php
    if($userDetail["user_ID"] == $_SESSION['id']){
?>
<h2>Rediger din profil</h2>
<form action="editProfile.php" method="post">
    <label>E-mail:</label>
    <input type="email" name="email" value="<?=$userDetail['email'];?>"><br>
    <label>Fornavn</label>
    <input type="text" name="firstname" placeholder="Fornavn" value="<?=$userDetail['firstname'];?>"><br>
    <label>Efternavn</label>
    <input type="text" name="surname" placeholder="Efternavn" value="<?=$userDetail['surname'];?>"><br>
    <label>Alder</label>
    <input type="number" name="age" max="99" value="<?=$userDetail['age'];?>"><br>
    <label>Køn</label>
    <select name="gender" autofocus="<?=$userDetail['gender'];?>">
        <option value="Male">Mand</option>
        <option value="Female">Kvinde</option>
        <option value="Other">Andet</option>
    </select><br>
    <label>By</label>
    <input type="text" name="city" placeholder="By" value="<?=$userDetail['city'];?>"><br>
    <label>Land</label>
    <input type="text" name="country" placeholder="Land" value="<?=$userDetail['country'];?>"><br>
    <label>Profil tekst</label><br>
    <textarea rows="5" cols="30" name="profileText"><?=$userDetail['profileText'];?></textarea><br>
    <input type="hidden" name="userId" value="<?=$userDetail['user_ID'];?>">
    <button type="submit">Gem</button>
</form>
<?php
        #validerEmail
        if ( isset($_POST['email']) ) { // test om variablen eksisterer
            if ( empty($_POST['email']) ) { // test om variablen er tom
                $fejlemail = 'Du skal udfylde feltet, klaphat';
                ++$fejl;
            } else if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) { // test om varibel er en email
                $fejlemail = "Emailen er ikke skrevet korrekt.";
                ++$fejl;
            } else { // success
                $email = $_POST['email'];
            }
        }

        #validerNavn
        if (isset($_POST['firstname'])){ // test om variablen eksisterer
            if (empty($_POST['firstname'])){ // test om variablen er tom
                $fejlproduktnavn = 'Du skal udfylde feltet, klaphat';
                ++$fejl;
            }else if (preg_match('/\d/', $_POST['firstname']) ) { // test om varibel indeholder tal
                $fejlproduktnavn = "DOH! Du ka' sgu' da ikke hedde noget med tal i. Spade.";
                ++$fejl;
            } else {//success
                $produktnavn = $_POST['firstname'];
            }
        }

        #validerEfternavn
        if (isset($_POST['surname'])){ // test om variablen eksisterer
            if (empty($_POST['surname'])){ // test om variablen er tom
                $fejlproduktnavn = 'Du skal udfylde feltet, klaphat';
                ++$fejl;
            }else if (preg_match('/\d/', $_POST['surname']) ) { // test om varibel indeholder tal
                $fejlproduktnavn = "DOH! Du ka' sgu' da ikke hedde noget med tal i. Spade.";
                ++$fejl;
            } else {//success
                $produktnavn = $_POST['surname'];
            }
        }

        #validerAlder
        if (isset($_POST['age'])){ //test om variablen eksistere
            if (empty($_POST['age'])){ // test om variablen er tom
                $fejlproduktpris = 'Du skal skrive din alder';
            }elseif (!is_numeric($_POST['age'])){
                $fejlproduktpris = 'Du må kun skrive tal her';
                ++$fejl;
            }else {//success
                $produktpris = $_POST['age'];
            }
        }

        #validerCIty
        if (isset($_POST['city'])){ // test om variablen eksisterer
            if (empty($_POST['city'])){ // test om variablen er tom
                $fejlproduktnavn = 'Du skal udfylde feltet';
                ++$fejl;
            }else if (preg_match('/\d/', $_POST['city']) ) { // test om varibel indeholder tal
                $fejlproduktnavn = "By navn kan ikke indholde tal";
                ++$fejl;
            } else {//success
                $produktnavn = $_POST['city'];
            }
        }

        #validerCountry
        if (isset($_POST['country'])){ // test om variablen eksisterer
            if (empty($_POST['country'])){ // test om variablen er tom
                $fejlproduktnavn = 'Du skal udfylde feltet';
                ++$fejl;
            }else if (preg_match('/\d/', $_POST['country']) ) { // test om varibel indeholder tal
                $fejlproduktnavn = "By navn kan ikke indholde tal";
                ++$fejl;
            } else {//success
                $produktnavn = $_POST['country'];
            }
        }

        #validerProfilText
        if (isset($_POST['profileText'])){ //test om variablen eksistere
            if (empty($_POST['profileText'])){ // test om variablen er tom
                $fejlproduktinfo = 'Du skal udfylde feltet';
                ++$fejl;
            }elseif (strlen($_POST['profileText']) <= 40){ //tjekker længden på strengen
                $fejlproduktinfo = 'Du skal bruge mere en 40 tegn';
                ++$fejl;
            }else { // success
                $produktinfo = $_POST['profileText'];
            }
        }

    }
