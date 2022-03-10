<html>
    <body>
<?php
    #require 'config.php';
    session_start();
    $db = 'capstonestudents';
    $host = 'localhost';
    $dsn = "mysql:host=localhost;dbname=capstonestudents";
    $un = "student";
    $pw = "testPW";
    try
    {
        $db = new PDO($dsn, $un, $pw);
    }catch(PDOException $e)
    {
        echo "could not connect to database";
    }
    if(!isset($_SESSION['user_login']))
    {
        echo"Please login";
        echo "<a href=login.php>Login Here</a>";
    }else{
        echo "Welcome " . $_SESSION['fName'] . " " . $_SESSION['lName'] . "!";
        echo "<a href=modules.php>HOME</a> <a href=logout.php>LOGOUT</a> <a href=scoreBoard.php> LEADERBOARD</a>";
    }
?>