<?php include("index.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';


if($_GET['key'] && $_GET['token']){
    $email = $_GET['key'];
    $token = $_GET['token'];
    echo "Email " . $email . "<br>";
    echo "token " . $token. "<br>";

    
    $statement = "SELECT * FROM students WHERE verifyToken= '$token' AND email = '$email';";
    $results = $db->query($statement);

    
    $curDate = date("Y-m-d H:i:s");
    echo "Results null? <br>";
    if($results->rowCount() > 0){
        $row = array($results);
        echo "First if <br>";
        if(array_column($row,'expDate') >= $curDate){
            #Set verify bit to true here redirect to login.php
            #Need to change login.php so verify bit has to be true for students to login
            $db->exec("UPDATE students SET verifyBit = 1, verifyToken = NULL, expDate = NULL WHERE email='$emailID';");
            $db->commit();
            echo "<a href=login.php>Login</a>";
        }
    }else{
        echo "<p>This User Verification Link Has Expired Please Try Again</p><br> <a href=login.php>Login</a>";
        print_r($results);
    }
}

?>