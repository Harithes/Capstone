<?php include("index.php");
$classID = $db->prepare("SELECT classId from classes");
$classID->execute();

?>
<html>
    <h2>Create User:</h2>
    <form action="verifyUser.php" method="POST">
        <p>Email: </p><input type=text name="email" maxlength="50" required>
        <p>First name: </p><input type=text name="fname" maxlength="50" required>
        <p>Last name: </p><input type=text name="lname" maxlength="50" required>
        <p>Password: </p><input type=password name="pw" maxlength="50"required>
        <?php 
        echo "<p>Class Id: </p><select id='classId' name='classId' required/>
        <datalist id='classId' >";
        foreach($classID as $ID){
            echo "<option value=".$ID["classId"].">".$ID["classId"]."</option>";
        } 
        echo "</select>";
        ?>
        <input type=hidden name="hidden" value=true>
        <input type=submit value="GO!">
    </form>
</html>