<!DOCTYPE html>
<html>

<head>
    <title>Edit Movie</title>
    <link REL="stylesheet" TYPE='text/css' href="styles.css">
    <script type="text/javascript" src="scrip2.js"></script>
</head>
<body>
    <div class="navbar">
    <a style="text-decoration:none" href="main.php"><p class="mv">Movies</p></a>
    <a style="text-decoration:none" href="main.php?section=Actor"><p class="ac ">Actors</p></a>
    </div>
    

    <div class="content movies-container" >
        <h1>Edit Movie</h1>
        <a href="main.php"><button class = "backbutton">Go back</button></a>
        <?php

        $db_host = "mysql.cs.nott.ac.uk";
        $db_user = 'psymk6_COMP1004'; // change 
        $db_pass = 'RRYNKS'; // change me
        $db_name = 'psymk6_COMP1004'; // change me

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_errno)  die("failed to connect to database\n</body>\n</html>"); 

        if (isset($_GET["id"])) {
            $MovieID = $_GET["id"];
        }
        
        if (isset($_POST['submit'])) {
            $fail = validate_id($_POST['mvID']);
            $fail+= validate_title($_POST['Title']);
            $fail+= validate_genre($_POST['Genre']);
            $fail+= validate_price($_POST['Price']);
            $fail+= validate_id($_POST['ActID']);
            $fail+= validate_year($_POST['Year']);
            if($fail == ""){
                $update_id = $_POST['mvID'];
                $update_title = $_POST['Title'];
                $update_genre = $_POST['Genre'];
                $update_price = $_POST['Price'];
                $update_ActID = $_POST['ActID'];
                $update_Year = $_POST['Year'];


                $stmt = $conn->prepare("UPDATE Movie SET mvTitle=?, mvGenre=?, mvPrice=?, actID=? ,mvYear=? WHERE mvID=?");
                $stmt->bind_param("ssdiii",$update_title, $update_genre, $update_price, $update_ActID, $update_Year, $update_id);
                if ($stmt->execute() === TRUE) {
                    echo "Movie updated successfully";
                } 
                else {
                    echo "Error updating movie: " . $conn->error;
                }
            }else return $fail;
        }

        $sql="SELECT actID,mvTitle,mvPrice,mvGenre,mvYear FROM Movie WHERE mvID = ".$MovieID;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($ActID,$Title, $Price, $Genre, $Year);

        if (isset($_GET["id"])) {
            $MovieID = $_GET["id"];
            while($stmt->fetch()){
                echo '<form method="POST" class="editForm" onsubmit="return validateMovie(this)">';
                echo    '<label for="title">Title:</label>';
                echo    '<input type="text" class = "editText" id="Title" name="Title" value="'.htmlentities($Title).'"><br>';
                
                echo    '<label for="genre">Genre:</label>';
                echo    '<input type="text" class = "editText" id="Genre" name="Genre"  value="'.htmlentities($Genre).'"><br>';
                
                echo    '<label for="price">Price:</label>';
                echo    '<input type="text" class = "editText" id="Price" name="Price"  value="'.htmlentities(round($Price,2)).'"><br>';
                
                echo    '<label for="ActID">Leading Actor ID:</label>';
                echo    '<input type="text" class = "editText" id="ActID" name="ActID"  value="'.htmlentities($ActID).'"><br>';

                echo    '<label for="price">Year:</label>';
                echo    '<input type="text" class = "editText" id="Year" name="Year"  value="'.htmlentities($Year).'"><br>';
                
                echo    '<input type="hidden" name="mvID" value="'.$MovieID.'">';
                echo    '<input type="submit" name="submit" value="Save">';
                echo '</form>';
            }
        }
        
        ?>
    
    </div?
</body>
<html>
<?php 
function validate_title($field){
    if ($field == "") 
        return "No title was entered.<br>";
    else if (preg_match("/[^a-zA-Z 0-9-]/",$field))
        return "Only letters, numbers and dashes are allowed in title.<br>";
    else return "";
}
function validate_genre($field){
    if ($field == "") 
        return "No genre was entered.<br>";
    else if (preg_match("/[^a-zA-Z 0-9-]/",$field))
        return "Only letters, numbers and dashes are allowed in genre.<br>";
    else if(strlen($field)<3)
        return "Genre must be at least 3 characters!<br>";
    else return "";
}
function validate_price($field){
    if ($field == "") return "No price was entered.<br>";
    else if (preg_match("/[^0-9.]/",$field))
        return "Only whole numbers or floats are allowed as price.<br>";
    else if ($field<0)
        return "Enter a non-negative value in the price field!<br>";
    else return "";
}
function validate_year($field) {
    if ($field=="")
        return "Enter a year!<br>";
    else if (preg_match("/[^0-9.]/",$field))
        return "Enter a numerical value in the year field!<br>";
    else if ($field<0)
        return "Enter a non-negative value in the year field!<br>";
    else
        return "";
}
function validate_id($field) {
    if ($field=="")
        return "Invalid ID!<br>";
    else if (preg_match("/[^0-9.]/",$field))
        return "Invalid ID!<br>";
    else if ($field<0)
        return "Invalid ID!<br>";
    else
        return "";
}?>