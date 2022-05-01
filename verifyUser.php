<?php include("index.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

#require 'C:/xampp/COMPOSER/vendor/autoload.php';
require '/vendor/autoload.php';
#Create user in db
    if(isset($_POST['hidden'])){
        $newEmail = $_POST['email'];
        $fName = $_POST['fname'];
        $lName = $_POST['lname'];
        $newPw = $_POST['pw'];
        $newId = $_POST['classId'];

        

        #Creating new user start
        try
        {
            $select = $db->prepare("SELECT email from students where email like '$newEmail'");
            $select->execute();
            if($select->rowCount() > 0)
            {
                echo "email already in use! Please try a different email.";
            }
            else
            {
                try
                {
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $db->beginTransaction();
                    $hashPw = password_hash($newPw, PASSWORD_BCRYPT);
                       
                    
                    $insert = "INSERT INTO students (email, fName, lName, hashWord, classId) VALUES (:email, :fName, :lName, :hashPw, :id)";
                    $stmt = $db->prepare($insert);
                    $stmt->bindValue(':email', $newEmail);
                    $stmt->bindValue(':fName', $fName);
                    $stmt->bindValue(':lName', $lName);
                    $stmt->bindValue(':hashPw', $hashPw);
                    $stmt->bindValue(':id', $newId, PDO::PARAM_INT);
                    $stmt->execute();
                    $db->commit();
                    
                    
                    
                    
                    
                }
                catch(PDOException $e)
                {
                    echo $e->getMessage();
                }
            }
        }
        catch(PDOException $e)
        {
            echo "Couldn't query!";
        }
        

        
    }
#end user create db

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
                
                
    
                $link = "<a href = 'http://localhost/sandbox/seniorCapstone/testing/setVerify.php?key=".$newEmail."&token=".$vToken."'>Click to Verify</a>";
                #require_once('phpmail/PHPMailerAutoload.php');
    
                $mail = new PHPMailer(true);
    
                // enable SMTP authentication
                #$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
                $mail->IsSMTP();
                
                // Set SMTP server
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;  
                $mail->Username = "WesternBusinessSim@gmail.com";
                $mail->Password = "BSimWestern2022";
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
