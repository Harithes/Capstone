<?php include("index.php");
echo "<h2>MAKE CLASS</h2>";
?>
<form method=POST>
    <p>Class Name:</p><input type="text" name="className" required><br><br>
    <p>Class Id: </p><input type="number" name="classId" value="classId" required><br>
    <input type=hidden name="hidden" value=true>
    <input type="submit" id="makeClass" value="Submit!">
</form>

<?php
if(isset($_POST['hidden'])){
    echo "WE BE MAKING A CLASS";
    $className = $_POST['className'];
    $classId = $_POST['classId'];
    echo "NAME AND ID: $className $classId";
    $_SESSION['classId'] = $classId;
    $profId = $_SESSION['profId'];

    try{
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();
        $insert = "INSERT INTO classes (profId, classId, className) VALUES (:id, :classId, :className)";
        $stmt = $db->prepare($insert);
        $stmt->bindValue(':id', $profId);
        $stmt->bindValue(':classId', $classId);
        $stmt->bindValue(':className', $className);
        $stmt->execute();
        $db->commit();
        header("location: modules.php");
    }catch(PDOException $e)
    {
        echo $e->getMessage();
    }
}
?>