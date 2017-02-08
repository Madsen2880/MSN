<?php

require_once './lib/class.mysql.php';

$conn = new dbconnector();
$query = $conn->newQuery("SELECT id, username, email FROM `users`");
if($query->execute()){
?>
<table border=1>
    <thead>
        <tr>
            <th>Username</th>
            <th>E-mail</th>
            <th>Profile</th>
        </tr>
    </thead>
<tbody>
<?php
    while($user = $query->fetch(PDO::FETCH_ASSOC)){
?>
    <tr>
        <td><?=$user["username"]?></td>
         <td><?=$user["email"]?></td>
          <td><a href="profile.php?id=<?=$user['id']?>">Visit</a></td>
    </tr>

<?php
    }
    $conn = null;
}
?>
</tbody>
</table>
