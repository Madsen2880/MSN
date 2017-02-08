<?php

session_start();
require_once './lib/class.mysql.php';

if(isset($_SESSION['isLoggedIn'])){
    session_destroy();
}

if($_POST){
    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

            $conn = new dbconnector();
            $query = $conn->newQuery("SELECT id, password FROM `users` WHERE username = :username");
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount()){
                $result = $query->fetch(PDO::FETCH_ASSOC);

                if(password_verify($password, $result['password'])){
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['isLoggedIn'] = true;
                    $conn = null;
                    header('Location: ./');
                }else{
                    $conn = null;
                    $errorMsg = "Forkert brugernavn/password.";
                }
            }else{
                $errorMsg = "Forkert brugernavn/password.";
            }
    }else{
        $errorMsg = "Alle felter skal udfyldes!";
    }
}

?>

<form action="" method="post">
    <h2>Login:</h2>
    <label>Brugernavn;</label>
    <input type="text" name="username" placeholder="Brugernavn">
    <label>Password</label>
    <input type="password" name="password" placeholder="password">
    <button type="submit">Login</button>
    <p style="color: red"><?=@$errorMsg;?></p>
</form>