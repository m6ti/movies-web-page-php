<!DOCTYPE html>
<html>

<head>
    <title>Edit Actor</title>
    <link REL="stylesheet" TYPE='text/css' href="styles.css">
    <script type="text/javascript" src="scrip2.js"></script>
</head>
<body>
    <div class="navbar">
    <a style="text-decoration:none" href="main.php"><p class="mv">Movies</p></a>
    <a style="text-decoration:none" href="main.php?section=Actor"><p class="ac ">Actors</p></a>
    </div>
    
    <div class="content movies-container" >
        <h1>Edit Actor</h1>
        <a href="main.php?section=Actor"><button class = "backbutton">Go back</button></a>

        
        <?php

        $db_host = "mysql.cs.nott.ac.uk";
        $db_user = 'psymk6_COMP1004'; // change 
        $db_pass = 'RRYNKS'; // change me
        $db_name = 'psymk6_COMP1004'; // change me

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_errno)  die("failed to connect to database\n</body>\n</html>"); 

        if (isset($_GET["id"])) {
            $ActorID = $_GET["id"];
        }
        
        if (isset($_POST['submit'])) {
            $fail = validate_name($_POST['actName']);
            $fail+= validate_id($_POST['actID']);
            if ($fail==""){
                $update_id = $_POST['actID'];
                $update_name = $_POST['actName'];
                
                $stmt = $conn->prepare("UPDATE Actor SET actName=? WHERE actID=?");
                $stmt->bind_param("si",$update_name, $update_id);
                if ($stmt->execute() === TRUE) {
                    echo "Actor updated successfully";
                } 
                else {
                    echo "Error updating actor: " . $conn->error;
                }
            }else echo $fail;

        }


        $sql="SELECT actName FROM Actor WHERE actID = ".$ActorID;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($actName);

        if (isset($_GET["id"])) {
            while($stmt->fetch()){
                echo '<form method="POST" class="editForm" onsubmit="return validateActor(this)">';
                echo    '<label for="title">Actor name:</label>';
                echo    '<input type="text" class = "editText" id="actName" name="actName" value="'.htmlentities($actName).'"><br>';
                
                echo    '<label for="ActID">Actor ID:</label>';
                echo    '<input type="text" class = "editText" id="ActID" name="ActID"  value="'.htmlentities($ActorID).' " readonly><br>';
                echo    '<input type="hidden" id="actID" name="actID" value="'.$ActorID.'">';

                echo    '<input type="submit" id="submit" name="submit" value="Save">';
                echo '</form>';
            }
        }

        function validate_name($field){
            if ($field == "") return "No name was entered.<br>";
            else if (strlen($field)<2)
                return "Name must be at least 2 characters.";
            else if (preg_match("/[^a-zA-Z ]/",$field))
                return "Only letters are allowed in name.";
            else return "";
        }
        function validate_id($field) {
            if ($field=="")
                return "Invalid ID!<br>";
            else if (preg_match("/[^0-9]/",$field))
                return "Invalid ID!<br>";
            else if ($field<0)
                return "Invalid ID!<br>";
            else
                return "";
        }

        ?>
    </div>
</body>
<html>
