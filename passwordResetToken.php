<?php
session_start();
$db = 'capstonestudents';
$host = 'us-cdbr-east-05.cleardb.net';
$dsn = "mysql:host=us-cdbr-east-05.cleardb.net;dbname=capstonestudents";
$un = "b36d9559844521";
$pw = "7383d077";
try
{
    $db = new PDO($dsn, $un, $pw);
}catch(PDOException $e)
{
    echo "could not connect to database";
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'C:\xampp\COMPOSER\vendor\autoload.php';

if(isset($_POST['userType']) && $_POST['userType'] == 'prof'){
    echo "Proffesor Selected<br>";
    $_SESSION['profEmail'] = true;
    $_SESSION['studentEmail'] = false;
}

if(isset($_POST['userType']) && $_POST['userType'] == 'stud'){
    echo "Student Selected<br>";
    $_SESSION['studentEmail'] = true;
    $_SESSION['profEmail'] = false;
}

if(isset($_POST['passwordResetToken'])&& $_POST['email']){
    $emailID = $_POST['email'];
    if($_SESSION['studentEmail'] == true){
        $statement = "SELECT * FROM students WHERE email = '$emailID';";
        $results = $db->query($statement);
    }
    else if($_SESSION['profEmail'] == true){
        $statement = "SELECT * FROM profs WHERE email = '$emailID';";
        $results = $db->query($statement);
    }

    if($results != null){
        $token = md5($emailID).rand(10,99);

        $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"));
        $expDate = date("Y-m-d H:i:s", $expFormat);
        
        #$query = "UPDATE students SET resetToken='$token',expDate='$expDate',WHERE email='$emailID'";
        #$stmt = $db->prepare($query);
        #$stmt->execute();
        try{
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();

            if($_SESSION['studentEmail'] == true){
                $db->exec("UPDATE students SET resetToken = '$token', expDate ='$expDate' WHERE email='$emailID';");
                $db->commit();
            }
            else if($_SESSION['profEmail'] == true){
                $db->exec("UPDATE profs SET resetToken = '$token', expDate ='$expDate' WHERE email='$emailID';");
                $db->commit();
            }

            $link = "<a href = 'http://localhost/sandbox/Capstone-main-recent/Capstone-main/resetPassword.php?key=".$emailID."&token=".$token."'>Click to Reset Password</a>";
            #require_once('phpmail/PHPMailerAutoload.php');

            $mail = new PHPMailer(true);

            // enable SMTP authentication
            #$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail->IsSMTP();
            
            // Set SMTP server
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;  
            $mail->Username = "WesternBusinessSim@gmail.com";
            $mail->Password = "Western2022";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            
            //Setting SMTP port for server
            $mail->Port = "465";
            $mail->setFrom = "WesternBusinessSim@gmail.com";
            $mail->FromName = "Western Business Sim";
            $mail->AddAddress($emailID);
            $mail->Subject = 'Reset Password';
            $mail->IsHTML(true);
            $mail->Body = 'Click This Link to Reset your Password for Buisness Sim '. $link . '';
        

        if($mail->Send()){
            echo "Check your Email and Click the link sent to your email <br> <a href=login.php>Back to Login Page</a>";
        }
    }catch(phpmailerException $e){
        echo $e->errorMessage();
        echo "<br> <a href=login.php>Login</a>";
    }catch(Exception $e){
        echo $e->getMessage();
        echo "<br> <a href=login.php>Login</a>";
    }
    }else{
        echo "Invalid Email Address. Go Back. <br> <a href=login.php>Login</a>";
    }
}
?>
