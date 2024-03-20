<!DOCTYPE html>
<html>

<head>
    <title>Add Actor</title>
    <link REL="stylesheet" TYPE='text/css' href="styles.css">
    <script type="text/javascript" src="scrip2.js"></script>
</head>
<body>
    <div class="navbar">
    <a style="text-decoration:none" href="main.php"><p class="mv">Movies</p></a>
    <a style="text-decoration:none" href="main.php"><p class="ac ">Actors</p></a>
    </div>
    

    <div class="content movies-container" >
        <h1>Add Actor</h1>
        <a href="main.php?section=Actor"><button class = "backbutton">Go back</button></a>
        <?php

        $db_host = "mysql.cs.nott.ac.uk";
        $db_user = 'psymk6_COMP1004'; // change 
        $db_pass = 'RRYNKS'; // change me
        $db_name = 'psymk6_COMP1004'; // change me

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_errno)  die("failed to connect to database\n</body>\n</html>"); 
        
        if (isset($_POST['submit'])) {
            $fail = validate_name($_POST['actName']);
            if ($fail==""){
                $act_name = $_POST['actName'];
                $stmt = $conn->prepare("INSERT INTO Actor (actName) VALUES ('$act_name')");
                if ($stmt->execute() === TRUE) {
                    echo "Actor added successfully";
                } 
                else {
                    echo "Error adding actor: " . $conn->error;
                }
            }else echo $fail;
            
        }
        ?>
        <form method="POST" class="editForm" onsubmit="return validateActor(this)">
            <label for="title">Actor name:</label>
            <input type="text" class = "editText" id="actName" name="actName" placeholder="Enter actor name"><br>
            <input type="submit" id="submit" name="submit" value="Add">
        </form>
    </div?
</body>

<html>
<?php 
function validate_name($field){
    if ($field == "") return "No name was entered.<br>";
    else if (strlen($field)<2)
        return "Name must be at least 2 characters.";
    else if (preg_match("/[^a-zA-Z ]/",$field))
        return "Only letters are allowed in name.";
    else return "";
}
?>
