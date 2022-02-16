<?php include('index.php'); ?>
<html>

<form action='submissions.php' method = "POST">
    Response Goes here
    <br>
    <input type="text" name="response1" required></input>
    <input type="submit" name="response1Submit" value="Submit Response">
</form>

<?php
    if(isset($_POST['response1Submit'])){
        $answer = $_POST['response1'];
        $lname = $_SESSION['lName'];
        try{
            $update = "UPDATE students SET mod1Sub = 1, mod1Response = $answer WHERE lName = '$lname'";
            $stmt = $db->prepare($update);
            $stmt->execute();
            $stmt->rowCount() . " records UPDATED successfully!";
            //header('Location: submissions.php');
        }catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
?>

</html>