<?php
session_start();
$db = 'heroku_ea376caa8695210';
$host = 'us-cdbr-east-05.cleardb.net';
$dsn = "mysql:host=us-cdbr-east-05.cleardb.net;dbname=heroku_ea376caa8695210";
$un = "b36d9559844521";
$pw = "7383d077";
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

    if($_SESSION['studentEmail'] == true){
        $query = "SELECT * FROM students WHERE resetToken='$token' AND email = '$emailID';";
        $statement = $db->prepare($query);
        $statement->execute();
    }
    else if($_SESSION['profEmail'] == true){
        $query = "SELECT * FROM profs WHERE resetToken='$token' AND email = '$emailID';";
        $statement = $db->prepare($query);
        $statement->execute();
    }

    
    if($statement->rowCount() > 0){

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();

        #$db->exec("UPDATE students SET resetToken = '$token', expDate ='$expDate' WHERE email='$emailID';");
        #$db->commit();

        if($_SESSION['studentEmail'] == true){
            $db->exec("UPDATE students SET hashWord = '$hashPw', resetToken = NULL, expDate = NULL WHERE email='$emailID';");
            $db->commit();
        }
        else if($_SESSION['profEmail'] == true){
            $db->exec("UPDATE profs SET hashWord = '$hashPw', resetToken = NULL, expDate = NULL WHERE email='$emailID';");
            $db->commit();
        }

        #$query = "UPDATE students set password=". $password . ", resetLinkToken = ". NULL . ", expDate = ".NULL."WHERE email= ".$emailID.";";
        #$statement = $pdo->prepare($query);
        #$statement->execute();
        echo '<p>Password Rest</p> <br> <a href=login.php>Login</a>';
    }else{
        echo '<p>Somthing went wrong. Please try again</p>';
    }
}
?>
