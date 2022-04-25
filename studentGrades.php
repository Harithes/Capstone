<?php include("index.php");

$overallGrade = 0.0;
$fName = $_SESSION['fName'];
$lName = $_SESSION['lName'];
$profChanged = 1;
$db->beginTransaction();
$statement = "SELECT * FROM modSubs WHERE fName = :fName AND lName = :lName AND profChanged = :profChanged";
$stmt = $db->prepare($statement);
$stmt->bindValue(':fName', $fName);
$stmt->bindValue(':lName', $lName);
$stmt->bindValue(':profChanged', $profChanged);
$stmt->execute();
$results = $stmt->fetchAll();
$db->commit();
if(count($results) == 0){
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