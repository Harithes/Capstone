<html>
    <body>
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
    if((!isset($_SESSION['user_login'])) && (!isset($_SESSION['prof_login'])))
    {
        echo"Please login";
    }else if(isset($_SESSION['user_login'])){
        echo "Welcome " . $_SESSION['fName'] . " " . $_SESSION['lName'] . "!<br>";
        echo "<a href=modules.php>HOME</a> <a href=logout.php>LOGOUT</a> <a href=studentGrades.php> GRADES</a><br>";
    }else if(isset($_SESSION['prof_login'])){
        echo"Welcome professor " . $_SESSION['lName'] . "!<br>";
        echo "<a href=modules.php>HOME</a> <a href=logout.php>LOGOUT</a> <a href=grading.php> STUDENT RESPONSES</a><br>";
    }
?>
