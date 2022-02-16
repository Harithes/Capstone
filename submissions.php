<?php
include("index.php");
$classId = $_SESSION['classId'];
//if(isset($_POST['response1Submit'])){
    $statement = "SELECT * from students where mod1Sub = 1 AND classId = $classId";
    $results = $db->query($statement);
    if($results == false){
        echo "Something broke!";
    }else{
        echo"<table>";
        echo"<tr>
        <td>Student Email:</td>
        <td>First Name:</td>
        <td>Last name:</td>
        <td>Response:</td>
        </tr>";
        foreach($results as $row){
            $email = "{$row['email']}";
            $fName = "{$row['fName']}";
            $lName = "{$row['lName']}";
            $response = "{$row['mod1Response']}";
            echo"<tr>
            <td>$email</td>
            <td>$fName</td>
            <td>$lName</td>
            <td>$response</td>
            </tr>";
        }
        echo"</table>";
    }
//}

if(isset($_POST['response2Submit'])){
    $response2 = $_POST['response2'];
}else{
    $response2 = "";
}

?>
