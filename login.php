<?php include("index.php");?>
<html>
    <h2>Login:</h2>
    <form method="POST">    
        <p>Email: </p><input type=text name="loginEm" maxlength="50" required>
        <p>Password: </p><input type=password name="loginPw" maxlength="50"required>
        <input type=submit value="GO!">
    </form>
    <style>
        div{padding-top: 390px}
    </style> 
    <div><a href="newUser.php">Create a new user</a> <a href="forgetPassword.php">Forgot password?</a> <a href="createProf.php">Create new professor</a> <a href="resendVerify.php">Resend email verification</a></div>
</html>
<?php

    if(isset($_POST['loginEm'])){
        $attemptEm = $_POST['loginEm'];
        $attemptPw = $_POST['loginPw'];
        $verifyBit = 1;
        $db->beginTransaction();
        $statement = "SELECT * from students where verifyBit = :vBit AND email = :email";
        $stmt = $db->prepare($statement);
        $stmt->bindValue(':vBit', $verifyBit);
        $stmt->bindValue(':email', $attemptEm);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $db->commit();
        if(count($results) == 0){
            $db->beginTransaction();
            $statement = "SELECT * from profs where email = :email";
            $stmt = $db->prepare($statement);
            $stmt->bindValue(':email', $attemptEm);
            $stmt->execute();
            $results = $stmt->fetchAll();
            $db->commit();
            if(count($results) == 0){
                echo "Invalid login, please try again";
            }else{
                foreach($results as $row){
                    $realPass = "{$row['hashword']}";
                    if(passWord_verify($attemptPw, $realPass) == true){
                        $_SESSION['prof_login'] = true;
                        $_SESSION['email'] = $attemptEm;
                        $_SESSION['fName'] = "{$row['fName']}";
                        $_SESSION['lName'] = "{$row['lName']}";
                        $_SESSION['profId'] = "{$row['profId']}";
                        $_SESSION['badPageForIndex'] = 1;
                        $_SESSION['loggedIn'] = true;
                        header('Location: selectClass.php');
                    }
                }
            }
        }if(count($results) > 0){
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
        }else{
            echo "Email invalid";
        }
    }
?>