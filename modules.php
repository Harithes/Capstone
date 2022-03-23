<?php
include("index.php");
?>
<table>
    <tr>
        <td>Module Name</td>
        <td>Extra Resources</td>
    </tr>
<?php if(isset($_SESSION['user_login'])) //student view
{
    $currId = $_SESSION['classId'];
    $statement = "SELECT * FROM modules WHERE classId = '$currId'";
    $results = $db->query($statement);?>
<style>
        table,th,td{border: 1px solid black}
</style>  
    <?php
    foreach($results as $row){
        echo "<tr><td> {$row['subtext']}</td><td><a href='resources.php'>Resources</a></td>";
    }
    ?>

    
</table>

<?php //prof view
}elseif(isset($_SESSION['prof_login'])){
    echo"<br>Your modules:<br>";
    $currId = $_SESSION['classId'];
    $statement = "SELECT * FROM modules WHERE classId = '$currId'";
    $results = $db->query($statement);?>
    <table>
    <style>
        table,th,td{border: 1px solid black}
    </style> 
    <?php foreach($results as $row){
        echo "<tr><td> {$row['modName']}</td><td><a href='resources.php'>Resources</a></td> <td><input type=submit name='updateMod' value='Update'>  
        <input type=submit name='deleteMod' value='Delete'></td>";
    }
?>
</table>
<form method="POST">
    <h3>Make a new Module: </h3>
    <input type=submit name="makeMod" value="CREATE!">
</form>
<?php if(isset($_POST['makeMod'])){
    header("Location: makeMod.php");
}
}