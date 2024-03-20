<?php 

    if (isset($_GET['id'])) {

    $mvID = $_GET['id'];

    $db_host = "mysql.cs.nott.ac.uk";
    $db_user = 'psymk6_COMP1004'; // change 
    $db_pass = 'RRYNKS'; // change me
    $db_name = 'psymk6_COMP1004'; // change me

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_errno)  die("failed to connect to database\n</body>\n</html>"); 

    $fail = validate_id($mvID);
    if($fail ==""){
        $stmt = $conn->prepare("DELETE FROM Movie WHERE mvID = $mvID");
        $stmt->execute();
    }
        echo "<script> window.location = 'main.php'; </script>";
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
}
?>