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

if($_GET['key'] && $_GET['token']){
    $email = $_GET['key'];
    $token = $_GET['token'];
    echo "Email " . $email . "<br>";
    echo "token " . $token. "<br>";

    if($_SESSION['studentEmail'] == true){
        $statement = "SELECT * FROM students WHERE resetToken= '$token' AND email = '$email';";
        $results = $db->query($statement);
    }else if($_SESSION['profEmail'] == true){
        $statement = "SELECT * FROM profs WHERE resetToken= '$token' AND email = '$email';";
        $results = $db->query($statement);
    }

    



    
    $curDate = date("Y-m-d H:i:s");
    echo "Results null? <br>";
    if($results->rowCount() > 0){
        $row = array($results);
        echo "First if <br>";
        if(array_column($row,'expDate') >= $curDate){
            echo "second if <br>";
            ?>
            <html>
            <form action="updatePassword.php" method="POST">
                <input type="hidden" name="email" value="<?php echo $email;?>">
                <input type="hidden" name="resetLinkToken" value="<?php echo $token;?>">
                Enter New Pasword
                <input type="password" name=password></input>
                <input type="submit" name="passReset"></input>
            </form>
            </html>
            <?php
        }
    }else{
        echo "<p>This Forget Password Link Has Expired Please Try Again</p><br> <a href=login.php>Login</a>";
        print_r($results);
    }
}

?>
