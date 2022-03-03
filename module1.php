<?php include('index.php');
$uId = $_SESSION['id'];
$statement = "SELECT mod1Sub from students where userId = '$uId';";
$results = $db->query($statement);
    foreach($results as $row){
        $mod1Sub = "{$row['mod1Sub']}";
    }

    if($mod1Sub == 1){
        echo"<br><a href='submissions.php'>View Submissions: </a>";
    }else{
        echo"<br><a href='response1.php'>Next Page -></a>";
    }
    ?>