<?php include('index.php'); ?>
<html>

<form method = "POST">
    Response Goes here
    <br>
    <input type="text" name="response1" required></input>
    <input type="submit" name="response1Submit" value="Submit Response">
</form>

<?php
    if(isset($_POST['response1Submit'])){
        $answer = $_POST['response1'];
        $uId = $_SESSION['id'];
        $sub = 1;
        echo$uId . "<br>";
        try{
            $update = "UPDATE students SET mod1Sub = $sub, mod1Response = '$answer' WHERE userId = $uId";
            $stmt = $db->prepare($update);
            $stmt->execute();
            //echo $stmt->rowCount() . " records UPDATED successfully!";
            header('Location: submissions.php');
        }catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
?>

</html>