<?php include("index.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';
?>
<html>
    <h2>Create User:</h2>
    <form action="verifyUser.php" method="POST">
        <p>Email: </p><input type=text name="email" maxlength="50" required>
        <input type=submit value="GO!">
    </form>
</html>


<?php

?>