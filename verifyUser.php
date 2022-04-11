<?php include("index.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

if(isset($_POST['email'])){
    $newEmail = $_POST['email'];
    $statement = "SELECT * FROM students WHERE email = '$newEmail';";
    $results = $db->query($statement);

        if($results != null){
            $vToken = md5($newEmail).rand(10,99);
    
            $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"));
            $expDate = date("Y-m-d H:i:s", $expFormat);
            
            #$query = "UPDATE students SET resetToken='$token',expDate='$expDate',WHERE email='$emailID'";
            #$stmt = $db->prepare($query);
            #$stmt->execute();
            try{
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->beginTransaction();
    
                $db->exec("UPDATE students SET verifyToken = '$vToken', expDate ='$expDate' WHERE email='$newEmail';");
                $db->commit();
                
                
    
                $link = "<a href = 'https://business-sim.herokuapp.com/setVerify.php?key=".$newEmail."&token=".$vToken."'>Click to Reset Password</a>";
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
                $mail->AddAddress($newEmail);
                $mail->Subject = 'Verify Account';
                $mail->IsHTML(true);
                $mail->Body = 'Click This Link to verify your account for Buisness Sim '. $link . '';
            
    
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