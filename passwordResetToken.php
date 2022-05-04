<?php
session_start();
$db = 'capstonestudents';
    $dsn = "mysql:host=bizsimdb.crwthttqqus8.us-east-1.rds.amazonaws.com;dbname=capstonestudents";
    $un = "admin";
    $pw = "testPWtest";
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

require '../vendor/autoload.php';

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
        $db->beginTransaction();
        $statement = "SELECT * FROM students WHERE email = :id";
        $stmt = $db->prepare($statement);
        $stmt->bindValue(':id', $emailID);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $db->commit();
        //$results = $db->query($statement);
    }
    else if($_SESSION['profEmail'] == true){
        $db->beginTransaction();
        $statement = "SELECT * FROM profs WHERE email = '$emailID';";
        $stmt = $db->prepare($statement);
        $stmt->bindValue(':id', $emailID);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $db->commit();
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
                $statement = "UPDATE students SET resetToken = :token, expDate =:expDate WHERE email= :id";
                $stmt = $db->prepare($statement);
                $stmt->bindValue(':token', $token);
                $stmt->bindValue(':expDate', $expDate);
                $stmt->bindValue(':id', $emailID);
                $stmt->execute();
                $db->commit();
            }
            else if($_SESSION['profEmail'] == true){
                $statement = "UPDATE profs SET resetToken = :token, expDate =:expDate WHERE email=:id";
                $stmt = $db->prepare($statement);
                $stmt->bindValue(':token', $token);
                $stmt->bindValue(':expDate', $expDate);
                $stmt->bindValue(':id', $emailID);
                $stmt->execute();
                $db->commit();
            }

            $link = "<a href = 'http://localhost/sandbox/seniorCapstone/testing/resetPassword.php?key=".$emailID."&token=".$token."'>Click to Reset Password</a>";
            #require_once('phpmail/PHPMailerAutoload.php');

            $mail = new PHPMailer(true);

            // enable SMTP authentication
            #$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail->IsSMTP();
            
            // Set SMTP server
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;  
            $mail->Username = "WesternBusinessSim@gmail.com";
            $mail->Password = "@U;Q$S3g(LF^GzzY";
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
