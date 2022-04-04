<?php include("index.php");

$overallGrade = 0.0;
$fName = $_SESSION['fName'];
$lName = $_SESSION['lName'];

$statement = "SELECT * FROM modSubs WHERE fName = '$fName' AND lName = '$lName' AND profChanged = 1;";
$results = $db->query($statement);
if($results->rowCount() == 0){
    echo"something broke!";
}else{
    echo"<style>table,th,td{border: 1px solid black}</style>";
        echo"<table>";
        echo"<tr>
        <td>Module name:</td>
        <td>Grade:</td>
        <td>Comment:</td>
        </tr>";
    $incrementer = 0;
    foreach($results as $row){
        $modName = "{$row['modName']}";
        $grade = "{$row['grade']}";
        $comment = "{$row['gradeComment']}";
        echo"<tr><td>$modName</td><td>$grade</td><td>$comment</td></tr>";
    }
}
?>