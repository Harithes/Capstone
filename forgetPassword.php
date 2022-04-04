<?php
session_start();
$db = 'heroku_ea376caa8695210';
$host = 'us-cdbr-east-05.cleardb.net';
$dsn = "mysql:host=us-cdbr-east-05.cleardb.net;dbname=heroku_ea376caa8695210";
$un = "b36d9559844521";
$pw = "7383d077";
$_SESSION['profEmail'] = false;
$_SESSION['studentEmail'] = false;
try
{
    $db = new PDO($dsn, $un, $pw);
}catch(PDOException $e)
{
    echo "could not connect to database";
}
?>
<html>
    <h2>Forgot Password:</h2>
    <form action="passwordResetToken.php" method="POST">    
        <p>Email: </p><input type=text name="email" maxlength="50" required>
        <input type="radio" name="userType" value="prof"/>
        <label for="prof">Proffesor:</label>
    
        <input type="radio" name="userType" value="stud" checked/>
        <label for="stud">Student:</label>
        <input type=submit name="passwordResetToken" value="Send email!">
    </form>
    <a href="login.php">Create a new user</a> <a href="createProf.php">Create new professor</a>
</html>
