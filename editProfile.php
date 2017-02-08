<?php
session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';

if($_POST){
    if(!empty($_POST["userId"]) && $_POST["userId"] == $_SESSION['id']){
        $userID = $_POST["userId"];
        $email = $_POST["email"];
        $firstname = $_POST["firstname"];
        $surname = $_POST["surname"];
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $profileText = $_POST["profileText"];
         
        $conn = new dbconnector();
        $query = $conn->newQuery("UPDATE users, userdetails 
        SET users.email = :EMAIL, userdetails.firstname = :FIRSTNAME, userdetails.surname = :SURNAME,
        userdetails.age = :AGE, userdetails.gender = :GENDER, userdetails.city = :CITY,
        userdetails.country = :COUNTRY, userdetails.profileText = :PROFILETEXT
        WHERE userdetails.UserId = :ID and users.id = :ID");

        $query->bindParam(":ID", $userID, PDO::PARAM_INT);
        $query->bindParam(":EMAIL", $email, PDO::PARAM_STR);
        $query->bindParam(":FIRSTNAME", $firstname, PDO::PARAM_STR);
        $query->bindParam(":SURNAME", $surname, PDO::PARAM_STR);
        $query->bindParam(":AGE", $age, PDO::PARAM_INT);
        $query->bindParam(":GENDER", $gender, PDO::PARAM_STR);
        $query->bindParam(":CITY", $city, PDO::PARAM_STR);
        $query->bindParam(":COUNTRY", $country, PDO::PARAM_STR);
        $query->bindParam(":PROFILETEXT", $profileText, PDO::PARAM_STR);

        if($query->execute()){
            $conn = null;
            echo 'Profil er blevet opdateret!';
        }else{
            $conn = null;
            echo 'Der skete en fejl og kunne ikke opdatere.';
        }

    }else{
        echo 'Ikke muligt at opdatere profil.';
    }
}

