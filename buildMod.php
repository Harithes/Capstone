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
echo "<br>$multipleChoice";
try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction();
    $insert = "INSERT INTO modules(classId, modName, modInfo, modQuestion,
      multipleChoice, mc1, mc2, mc3, mc4, written) VALUES (:id, :modName,
       :modInfo, :modQuestion, :multipleChoice, :mc1, :mc2, :mc3, :mc4, :written)";
    $stmt = $db->prepare($insert);
    $stmt->bindValue(':id', $classId);
    $stmt->bindValue(':modName', $modName);
    $stmt->bindValue(':modInfo', $modInfo);
    $stmt->bindValue(':modQuestion', $modQuestion);
    $stmt->bindValue(':multipleChoice', $multipleChoice, PDO::PARAM_INT);
    $stmt->bindValue(':mc1', $mc1);
    $stmt->bindValue(':mc2', $mc2);
    $stmt->bindValue(':mc3', $mc3);
    $stmt->bindValue(':mc4', $mc4);
    $stmt->bindValue(':written', $written, PDO::PARAM_INT);
    $stmt->execute();
    $db->commit();

    header("Location: modules.php");

}catch(PDOException $e){
    echo $e->getMessage();
}
?>