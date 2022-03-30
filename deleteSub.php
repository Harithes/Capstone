<?php
    include("index.php");
    if(!isset($_SESSION['prof_login']))
    {
    echo "<br>You must be a professor to delete a submission!<br>";
    }
    else
    {
    if (isset($_GET['id']))
    {
        $id = $_GET['id'];
        echo "<br>id you're attempting to delete: $id";
        try
        {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = "DELETE FROM modSubs WHERE submissionId = $id;";
            $db->exec($statement);
            echo "Record deleted successfully!<br>";
            header('Location: submissions.php');
        }catch(PDOException $e)
        {
            echo "Could not delete from database<br>";
        }
    }
    else
    {
        echo "<br>No name id found<br>";
    }
}
?>