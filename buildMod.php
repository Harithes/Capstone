<?php
include("index.php");
//echo "Let's build this mod:<br>Mod name:" .  $_SESSION['modName'] . "<br>Mod info: " . $_SESSION['modInfo'] . "<br>Mod question: " . $_SESSION['modQuestion'];
$modName = $_SESSION['modName'];
$modInfo = $_SESSION['modInfo'];
$modQuestion = $_SESSION['modQuestion'];
$multipleChoice = $_SESSION['multipleChoice'];
$written = $_SESSION['written'];
$mc1 = $_SESSION['mc1'];
$mc2 = $_SESSION['mc2'];
$mc3 = $_SESSION['mc3'];
$mc4 = $_SESSION['mc4'];

$classId = $_SESSION['classId'];

echo "<br>class id: $classId";
try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction();
    $db->exec("INSERT INTO modules(classId, modName, modInfo, modQuestion,
     multipleChoice, mc1, mc2, mc3, mc4, written) VALUES ($classId, '$modName',
      '$modInfo', '$modQuestion', $multipleChoice, '$mc1', '$mc2', '$mc3', '$mc4', $written);");
    $db->commit();

    header("Location: modules.php");

}catch(PDOException $e){
    echo "Couldn't query!";
}
?>