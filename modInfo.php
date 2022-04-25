<?php include("index.php");
if (isset($_GET['id'])){
    $currId = $_GET['id'];
    $_SESSION['currId'] = $currId;
    //echo"CURRENT MODULE ID: $currId";

    $db->beginTransaction();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $select = "SELECT modName, modInfo FROM modules WHERE modId = :id";
    $stmt = $db->prepare($select);
    $stmt->bindValue(':id', $currId);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $db->commit();
    foreach($results as $r)
    {
        $modName = "{$r['modName']}";
        $modInfo = "{$r['modInfo']}";
    }
    $_SESSION['modName'] = $modName;
    echo "<h2>$modName</h2>";
    echo "$modInfo<br>";

    echo "<a href=modQuestion.php?id=$currId>Go to Question</a>";
}else{
    echo("No GET id found");
}

?>