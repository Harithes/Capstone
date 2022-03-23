<?php include("index.php");?>

<html>
    <script type="text/javascript">
        function ShowHideDiv(){
        var multipleChoice = document.getElementById("multipleChoice");
        var writtenResponse = document.getElementById("writtenResponse");
        dvtext.style.display = multipleChoice.checked ? "block" : "none";
    }
    </script>
    <form method="POST">    
        <p>Module Name: </p><input type="text" name="modName" maxlength="50" required>
        <style>
            textarea{resize: none;}
        </style>
        <p>Module Info: </p><textarea id="modInfo" name="modInfo" rows="5" cols="50" required></textarea>
        <p>Module Question: </p><textarea id="modQuestion" name="modQuestion" rows="2" cols="50" required></textarea>
        <p>Response Type:</p><br><label>
            <input type="radio" name="responseType" id="writtenResponse" value="writtenResponse" onclick="ShowHideDiv()"required/>
            Written Response
</label><br>
<label>
    <input type="radio" name="responseType" id="multipleChoice" value="multipleChoice" onclick="ShowHideDiv()"/>
    Multiple Choice
</label>
<div id="dvtext" style="display: none">
    Response 1:
    <input type="text" id="resp1" name="resp1"></input><br>
    Response 2:
    <input type="text" id="resp2" name="resp2"></input><br>
    Response 3:
    <input type="text" id="resp3" name="resp3"></input><br>
    Response 4:
    <input type="text" id="resp4" name="resp4"></input><br>
</div>
<br>
<input type=submit name="createMod" value="Create!">
    </form>
</html>

<?php if(isset($_POST['createMod'])){
    $modName = $_POST['modName'];
    $modInfo = $_POST['modInfo'];
    $modQuestion = $_POST['modQuestion'];
    $response = $_POST['responseType'];
    $resp1 = $_POST['resp1'];
    $resp2 = $_POST['resp2'];
    $resp3 = $_POST['resp3'];
    $resp4 = $_POST['resp4'];

    echo $modName . ", " . $modInfo . ", " . $modQuestion . ", " . $response;
    if($response == "multipleChoice"){
        echo("MULTIPLE CHOICE!<br>");
        echo("$resp1<br>$resp2<br>$resp3<br>$resp4<br>");

    }else if($response == "writtenResponse"){
        echo("WRITTEN RESPONSE!<br>");
        $resp1 = "";
        $resp2 = "";
        $resp3 = "";
        $resp4 = "";
        echo("$resp1<br>$resp2<br>$resp3<br>$resp4<br>");
    }
}