<?php include("index.php");?>
<html>
    <h2>Login:</h2>
    <form method="POST">    
        <p>Email: </p><input type=text name="loginEm" maxlength="50" required>
        <p>Password: </p><input type=password name="loginPw" maxlength="50"required>
        <input type=submit value="GO!">
    </form>
    <a href="newUser.php">Create a new user</a> <a href="forgotPassword.php">Forgot password?</a> <a href="createProf.php">Create new professor</a>
</html>
<?php

    if(isset($_POST['loginEm'])){
        $attemptEm = $_POST['loginEm'];
        $attemptPw = $_POST['loginPw'];

        $statement = "SELECT * from students where email = '$attemptEm';";
        $results = $db->query($statement);
        echo $results->rowCount();
        if($results->rowCount() == 0){
            echo "Trying professors";
            $statement = "SELECT * from profs where email = '$attemptEm';";
            $results = $db->query($statement);
            if($results->rowCount() == 0){
                echo "Invalid login, please try again";
            }else{
                foreach($results as $row){
                    $realPass = "{$row['hashword']}";
                    if(passWord_verify($attemptPw, $realPass) == true){
                        $_SESSION['prof_login'] = true;
                        $_SESSION['email'] = $attemptEm;
                        $_SESSION['fName'] = "{$row['fName']}";
                        $_SESSION['lName'] = "{$row['lName']}";
                        $_SESSION['classId'] = "{$row['classId']}";

                        header('Location: modules.php');
                    }
                }
            }
        }else{
            echo "Here!";
            foreach($results as $row){
                $realPass = "{$row['hashWord']}";

                if(password_verify($attemptPw, $realPass) == true){
                    $_SESSION['user_login'] = true;
                    $_SESSION['email'] = $attemptEm;
                    $_SESSION['id'] = "{$row['userId']}";
                    $_SESSION['fName'] = "{$row['fName']}";
                    $_SESSION['lName'] = "{$row['lName']}";
                    $_SESSION['classId'] = "{$row['classId']}";
                    header('Location: modules.php');
                }
            }
        }
    }
?>
