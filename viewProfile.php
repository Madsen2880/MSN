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

        <?php
    }else{
        echo 'Bruger findes ikke';
    }
}else {
    header('Location: ./');
}
?>


<table border=1>
        <thead>
        <tr>
            <th>Profil Billede</th>
            <th>Fornavn:</th>
            <th>Efternavn:</th>
            <th>Alder:</th>
            <th>Køn:</th>
            <th>By:</th>
            <th>Land:</th>
            <th>Om mig:</th>
            <th>Profil Oprettet:</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($userDetail = $query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?= $userDetail["profilePicture"] ?></td>
                <td><?= $userDetail["firstname"] ?></td>
                <td><?= $userDetail["surname"] ?></td>
                <td><?= $userDetail["age"] ?></td>
                <td><?= $userDetail["gender"] ?></td>
                <td><?= $userDetail["city"] ?></td>
                <td><?= $userDetail["country"] ?></td>
                <td><?= $userDetail["profileText"] ?></td>
                <td><?= $userDetail["DateCreated"] ?></td>
                <td><a href="retProfil.php?id=<?=$userDetails?>">Rediger</a></td>


            </tr>

            <?php
        }
        $conn = null;

    }
        ?>

</tbody>

</table>