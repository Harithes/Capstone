<?php
session_start();
$db = 'capstonestudents';
$host = 'localhost';
$dsn = "mysql:host=localhost;dbname=capstonestudents";
$un = "student";
$pw = "testPW";
try
{
    $db = new PDO($dsn, $un, $pw);
}catch(PDOException $e)
{
    echo "could not connect to database";
}

echo "Are we on this page?";

if(isset($_POST['password']) && $_POST['resetLinkToken'] && $_POST['email']){
    $emailID = $_POST['email'];
    $token = $_POST['resetLinkToken'];
    $hashPw = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $query = "SELECT * FROM students WHERE resetToken='$token' AND email = '$emailID';";
    $statement = $db->prepare($query);
    $statement->execute();
    if($statement->rowCount() > 0){

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();

        #$db->exec("UPDATE students SET resetToken = '$token', expDate ='$expDate' WHERE email='$emailID';");
        #$db->commit();

        $db->exec("UPDATE students SET hashWord = '$hashPw', resetToken = NULL, expDate = NULL WHERE email='$emailID';");
        $db->commit();

        #$query = "UPDATE students set password=". $password . ", resetLinkToken = ". NULL . ", expDate = ".NULL."WHERE email= ".$emailID.";";
        #$statement = $pdo->prepare($query);
        #$statement->execute();
        echo '<p>Password Rest</p> <br> <a href=login.php>Login</a>';
    }else{
        echo '<p>Somthing went wrong. Please try again</p>';
    }
}
?>