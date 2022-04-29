<html>
<body>
    <link rel="stylesheet" href="style.css">
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
    if((!isset($_SESSION['user_login'])) && (!isset($_SESSION['prof_login'])))
    {
        echo"Please login: <a href=login.php>Back to login</a>";
    }else if(isset($_SESSION['user_login'])){
        echo "Welcome " . $_SESSION['fName'] . " " . $_SESSION['lName'] . "!<br>";
        echo "<a href=modules.php>HOME</a> <a href=logout.php>LOGOUT</a> <a href=studentGrades.php> GRADES</a><br>";
    }else if(isset($_SESSION['badPageForIndex'])){
        echo"Welcome professor " . $_SESSION['lName'] . "!<br>";
    }else if(isset($_SESSION['prof_login'])){
        echo"Welcome professor " . $_SESSION['lName'] . "!<br>";
        echo "<a href=modules.php>HOME</a> <a href=logout.php>LOGOUT</a> <a href=grading.php> STUDENT RESPONSES</a><br>";
    }
?>
