<?php

if($_GET['key'] && $_GET['token']){
    $email = $_GET['key'];
    $token = $_GET['token'];
    echo "Email " . $email . "<br>";
    echo "Token " . $token . "<br>";

    $statement = "SELECT * FROM students WHERE verifyToken= '$token' AND email = '$email';";
    $results = $db->prepare($statement);
    $results->execute();

    $curDate = date("Y-m-d H:i:s");
    echo "Results null? <br>";
    if($results->rowCount() > 0){
        $row = array($results);
        echo "First if <br>";
        if(array_column($row,'expDate') >= $curDate){
            echo "second if <br>";
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();
            $db->exec("UPDATE students SET verifyBit = 1, verifyToken = NULL, expDate = NULL WHERE email='$email';");
            $db->commit();
            
            echo '<p>Account Verified</p> <br> <a href=login.php>Login</a>';
        }
    }else{
        echo "<p>This verify Link Has Expired Please Try Again</p><br> <a href=login.php>Login</a>";
        print_r($results);
    }
}
echo "<a href=login.php>Login</a>";
?>
