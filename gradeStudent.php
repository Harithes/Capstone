<?php include("index.php");
if(isset($_GET['id'])){
    $gradeId = $_GET['id'];
    $statement = "SELECT * from modSubs where submissionId = $gradeId";
    $results = $db->query($statement);
    if($results->rowCount() == 0){
        echo "Nothing found!";
    }
    foreach($results as $row){
        $modName = "{$row['modName']}";
        $subInfo = "{$row['subInfo']}";
        $fName = "{$row['fName']}";
        $lName = "{$row['lName']}";
    }
}

echo "<h2>$modName:</h2><br>";
echo "<p>$fName $lName:<br>$subInfo</p>";
?>
<html>
    <form method="POST">
        <style>
            textarea{resize: none;}
        </style>
        <label for="grade">Grade (percentage between 0 and 100):</label>
        <input type="number" id="grade" name="grade" min="0" max="100" required>
        <p>Comment: </p><textarea id="comment" name="comment" rows="2" cols="50" required></textarea>
        <input type="submit" name="gradeStudent" value="Submit Grade">
    </form>
</html>

<?php
if(isset($_POST['gradeStudent'])){
    $grade = $_POST['grade'];
    $comment = $_POST['comment'];

    echo "GRADE: $grade<br>COMMENT: $comment";

    try
        {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->beginTransaction();
            $query = "UPDATE modSubs SET grade=$grade, gradeComment='$comment', profChanged=1 WHERE submissionId=$gradeId;";
            $statment = $db->prepare($query);
            $statment->execute();
            $db->commit();
            header('Location: submissions.php');
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }
}
?>