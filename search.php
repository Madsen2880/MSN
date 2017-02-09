<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Users</title>
</head>
<body>
<h3>Search Contacts</h3>
<p>You  may search either by first or last name</p>
<form action="search.php" method="post">
    Search: <input type="text" name="search" placeholder=" Search here ... "/>
    <input type="submit" value="Submit" />
</form>


<?php
//load database connection
include ('lib/class.mysql.php');
$conn = new dbconnector();

$host = "localhost";
$user = "root";
$password = "";
$database_name = "mysocialnetwork";
$pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
));
// Search from MySQL database table // noget er galt med den måde jeg kalder DB på...
$search=$_POST['search'];
$query = $pdo->prepare("SELECT userdetails, userID FROM user WHERE Surname, Firstname Like '%$userInput%' ");
$query->bindValue(1, "%$search%", PDO::PARAM_STR);
$query->execute();
// Display search result
if (!$query->rowCount() == 0) {
    echo "Search found :<br/>";
    while ($results = $query->fetch()) {
            echo "['Firstname'],['Surname']";
        // #Hvordan for jeg et output der sender brugeren til den profil de søger. evt. navnet man har fundet som
        // link til viewProfile.php siden?
    }
}       else {
        echo 'Nothing found';
}
?>
</body>
</html>
