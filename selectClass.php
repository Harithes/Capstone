<?php
include("index.php");
$profId = $_SESSION['profId'];
$statement = "SELECT * FROM classes WHERE profId = $profId";
$results = $db->query($statement);
if($results->rowCount() == 0){
    echo "You have no classes made! <br>Create a new class?";
}else{
    echo"<style>table,th,td{border: 1px solid black; padding: 15px}</style>";
        echo"<table>";
        echo"<tr>
        <td>Class Id:</td>
        <td>Class Name:</td>
        </tr>";
    foreach($results as $row){
        echo "<tr><td> <p>{$row['classId']}</p></td>
        <td><a href=modules.php?id={$row['classId']}>{$row['className']}</a></td>";
    }
}
    ?>
    </table>
    <form method="POST">
        <input type=submit name="makeClass" value="CREATE CLASS!">
    </form>
<?php 
if(isset($_POST['makeClass'])){
    header("Location: makeClass.php");
}

?>