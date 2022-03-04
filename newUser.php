<?php include("index.php");
$classID = $db->prepare("SELECT classId from profs");
$classID->execute();

?>
<html>
    <h2>Create User:</h2>
    <form method="POST">
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

<?php
    if(isset($_POST['hidden'])){
        $newEmail = $_POST['email'];
        $fName = $_POST['fname'];
        $lName = $_POST['lname'];
        $newPw = $_POST['pw'];
        $newId = $_POST['classId'];

        try
        {
            $select = $db->prepare("SELECT email from students where email like '$newEmail'");
            $select->execute();
            if($select->rowCount() > 0)
            {
                echo "email already in use! Please try a different email.";
            }
            else
            {
                try
                {
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $db->beginTransaction();
                    $hashPw = password_hash($newPw, PASSWORD_BCRYPT);

                    $db->exec("INSERT INTO students (email, fName, lName, hashWord, classId) VALUES ('$newEmail', '$fName', '$lName', '$hashPw', '$newId');");
                    $db->commit();
                    $_SESSION['user_login'] = true;
                    $_SESSION['email'] = $attemptEm;
                    $_SESSION['fName'] = "{$row['fName']}";
                    $_SESSION['lName'] = "{$row['lName']}";
                    $_SESSION['classId'] = "{$row['classId']}";
                    header('Location: modules.php');
                }
                catch(PDOException $e)
                {
                    echo $e->getMessage();
                }
            }
        }
        catch(PDOException $e)
        {
            echo "Couldn't query!";
        }
    }
?>