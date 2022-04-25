<?php include("index.php");
if (isset($_GET['id'])){
    $currId = $_GET['id'];
    $_SESSION['currId'] = $currId;
    $classId = $_SESSION['classId'];
    $fName = $_SESSION['fName'];
    $lName = $_SESSION['lName'];
    //echo"CURRENT MODULE ID: $currId";

    $db->beginTransaction();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $select = "SELECT * FROM modSubs WHERE fName = :fName AND lName = :lName AND modId = :id";
    $stmt = $db->prepare($select);
    $stmt->bindValue(':fName', $fName);
    $stmt->bindValue(':lName', $lName);
    $stmt->bindValue(':id', $currId);
    $stmt->execute();
    $results = $stmt->fetchAll();
    $db->commit();
    if(count($results) > 0){
        echo "You have already made a submission to this module! check submissions below:<br>
        <a href=submissions.php>Submissions</a>";
    }else{
        $db->beginTransaction();
        $select = "SELECT modName, modQuestion, multipleChoice, mc1, mc2, mc3, mc4, written FROM modules WHERE modId = :id";
        $stmt = $db->prepare($select);
        $stmt->bindValue(':id', $currId);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $db->commit();
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
    //NEED TO MAKE THIS WORK FOR LESS THAN 4 QUESTIONS(maybe?)
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
        $grade = 0;
        $comment = "";
        $profChanged = 0;
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();

        $statement = "INSERT INTO modSubs (modId, modName, classId, subInfo, fName, lName, grade, gradeComment, profChanged) 
        VALUES ($currId,'$modName', '$classId', '$answer', '$fName', '$lName', 0, '', 0)";
        $stmt = $db->prepare($statement);
        $stmt->bindValue('id', $currId);
        $stmt->bindValue(':modName', $modname);
        $stmt->bindValue(':classId', $classid);
        $stmt->bindValue(':answer', $answer);
        $stmt->bindValue(':fName', $fname);
        $stmt->bindValue(':lName', $lName);
        $stmt->bindValue(':grade', $grade);
        $stmt->bindValue(':comment', $comment);
        $stmt->bindValue(':profChanged', $profChanged);
        $stmt->execute();
        $db->commit();
        header('Location: submissions.php');
    }catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}
?>