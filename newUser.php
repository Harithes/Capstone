<?php include("index.php");
$classID = $db->prepare("SELECT classId from profs");
$classID->execute();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
?>
<html>
    <h2>Create User:</h2>
    <form method="POST">
        <p>Email: </p><input type=text name="email" maxlength="50" required>
        <p>First name: </p><input type=text name="fname" maxlength="50" required>
        <p>Last name: </p><input type=text name="lname" maxlength="50" required>
        <p>Password: </p><input type=password name="pw" maxlength="50"required>
        <?php 
        echo "<p>Class Id: </p><select id='classId' name='classId' required/>
        <datalist id='classId' >";
        foreach($classID as $ID){
            echo "<option value=".$ID["classId"].">".$ID["classId"]."</option>";
        } 
        echo "</select>";
        ?>
        <input type=hidden name="hidden" value=true>
        <input type=submit value="GO!">
    </form>
</html>

<?php
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

                    $db->exec("INSERT INTO students (email, fName, lName, hashWord, classId) VALUES ('$newEmail', '$fName', '$lName', '$hashPw', '$newId');");
                    $db->commit();
                    header('Location: login.php');
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
        #creating new user end

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
                
                
    
                $link = "<a href = 'https://business-sim.herokuapp.com/verifyUser.php?key=".$newEmail."&token=".$vToken."'>Click to Reset Password</a>";
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