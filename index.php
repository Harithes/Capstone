<html>
    <body>
<?php
    #require 'config.php';
    session_start();
    $db = 'heroku_ea376caa8695210';
    //$db = 'capstonestudents';
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
    }else{
        echo "Welcome " . $_SESSION['fName'] . " " . $_SESSION['lName'] . "!";
        echo "<a href=modules.php>HOME</a> <a href=logout.php>LOGOUT</a> <a href=scoreBoard.php> LEADERBOARD</a>";
    }

    
    //Get Heroku ClearDB connection information
    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $cleardb_server = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db = substr($cleardb_url["path"],1);
    $active_group = 'default';
    $query_builder = TRUE;
    // Connect to DB
    $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

?>