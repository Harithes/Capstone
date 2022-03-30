<?php include("index.php");
if (isset($_GET['id'])){
    $currId = $_GET['id'];
    $_SESSION['currId'] = $currId;
    //echo"CURRENT MODULE ID: $currId";

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $select = "SELECT modName, modInfo FROM modules WHERE modId = $currId";
    $results = $db->query($select);
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