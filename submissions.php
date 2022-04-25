<?php
include("index.php");
$classId = $_SESSION['classId'];
/*
if(isset($_SESSION['currId'])){
    $currId = $_SESSION['currId'];
}*/
if (isset($_GET['id'])){
    //echo "Getting";
    $id = $_GET['id'];
    //echo "<br>ID: $id";
    $db->beginTransaction();
    $select = "SELECT * from modules where modId = :id";
    $stmt = $db->prepare($select);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $db->commit();
    if(count($results) == 0){
        echo "Nothing found!";
    }
    foreach($results as $row){
        $_SESSION['modName'] = "{$row['modName']}";
    }
    //echo $_SESSION['modName'];
}
$modName = $_SESSION['modName'];
echo "<h2>$modName</h2>";
$db->beginTransaction();
$select = "SELECT * from modSubs where modName = :modName AND classId = :id";
$stmt = $db->prepare($select);
$stmt->bindValue(':modName', $modName);
$stmt->bindValue(':id', $classId);
$stmt->execute();
$results = $stmt->fetchAll();
$db->commit();
    if(count($results) == 0){
        echo "No submissions!";
    }else{
        echo"<style>table,th,td{border: 1px solid black}</style>";
        echo"<table>";
        echo"<tr>
        <td>First Name:</td>
        <td>Last Name:</td>
        <td>Response:</td>
        </tr>";
        foreach($results as $row){
            $fName = "{$row['fName']}";
            $lName = "{$row['lName']}";
            $subInfo = "{$row['subInfo']}";
            //$response = "{$row['mod1Response']}";
            echo"<tr>
            <td>$fName</td>
            <td>$lName</td>
            <td>$subInfo</td>";
            if(isset($_SESSION['prof_login'])){
                echo "<td>Grade: {$row['grade']}%</td>
                <td><a href=gradeStudent.php?id={$row['submissionId']}>change grade</a></td>
                <td><a href=deleteSub.php?id={$row['submissionId']}>delete</a></td";
            }
            echo "</tr>";
        }
        echo"</table>";
    }
?>