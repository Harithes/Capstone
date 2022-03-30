<?php include("index.php");
if (isset($_GET['id'])){
    $currId = $_GET['id'];
    $_SESSION['currId'] = $currId;
    $classId = $_SESSION['classId'];
    $fName = $_SESSION['fName'];
    $lName = $_SESSION['lName'];
    //echo"CURRENT MODULE ID: $currId";

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $select = "SELECT * FROM modSubs WHERE fName = '$fName' AND lName = '$lName'";
    $results = $db->query($select);
    if($results->rowCount() > 0){
        echo "You have already made a submission to this module! check submissions below:<br>
        <a href=submissions.php>Submissions</a>";
    }else{
        $select = "SELECT modName, modQuestion, multipleChoice, mc1, mc2, mc3, mc4, written FROM modules WHERE modId = $currId";
    $results = $db->query($select);
    foreach($results as $r)
    {
        $modName = "{$r['modName']}";
        $modQuestion = "{$r['modQuestion']}";
        $multiple = "{$r['multipleChoice']}";
        $mc1 = "{$r['mc1']}";
        $mc2 = "{$r['mc2']}";
        $mc3 = "{$r['mc3']}";
        $mc4 = "{$r['mc4']}";
        $written = "{$r['written']}";
    }
    $_SESSION['modName'] = $modName;
    echo "<h2>$modName</h2>";
    echo "$modQuestion<br><br>";
    if($multiple == 1){ ?>
       <html>
        <form method="POST">
            <label>
                <?php echo "<input type='radio' name='mcResponse' value='$mc1' required>";
                echo "$mc1"; ?>
    </label><br>
    <label>
    <?php echo "<input type='radio' name='mcResponse' value='$mc2'>";
         echo "$mc2";?>
    </label><br>
    <label>
    <?php echo "<input type='radio' name='mcResponse' value='$mc3'>";
         echo "$mc3";?>
    </label><br>
    <label>
    <?php echo "<input type='radio' name='mcResponse' value='$mc4'>";
         echo "$mc4";?>
    </label><br>
    </html>

    <?php
    }elseif($written == 1){ ?>
    <form method="POST">
        </p><textarea id="writtenResponse" name="writtenResponse" rows="10" cols="50" required></textarea>
    <?php }else{
    echo "COULD NOT FIND MOD ID";
    }
    ?>
    <br><input type=submit name="submitAnswer" value="Submit!">
    </form>
    <?php
    }
}
if(isset($_POST['submitAnswer'])){
    if($multiple == 1){
        $_SESSION['answer'] = $_POST['mcResponse'];
    }elseif($written==1){
        $_SESSION['answer'] = $_POST['writtenResponse'];
    }
    $answer = $_SESSION['answer'];
    echo "This is " . $_SESSION['modName'];

    try{
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();

        $db->exec("INSERT INTO modSubs (modId, modName, classId, subInfo, fName, lName) VALUES ($currId,'$modName', '$classId', '$answer', '$fName', '$lName');");
        $db->commit();
        header('Location: submissions.php');
    }catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}
?>