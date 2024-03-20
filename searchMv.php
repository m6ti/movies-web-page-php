<html>
    <head>
        <meta charset="utf-8">
        <title>Movies and Actors Search Result</title>
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript" src="scrip2.js"></script>
    </head>
    <body>

    <div class="search-panel" id="search-panel-movie">
        <form action="searchMv.php" method="POST" onsubmit="return validateSearch(this)">
            <label for="searchTerm">Enter search: </label>
            <input type="text" id="searchTerm" name="searchTerm">
            <label for="category">Search for:</label>
            <select name="category" id="category"required>
                <option value="mvTitle">Movie Title</option>
                <option value="mvGenre">Movie Genre</option>
                <option value="actName">Top Actor</option>
            </select>
            <br>
            <button type="submit">Search</button>
            <button type="button" class="backbutton" onclick="toggleSearchPanel('movie')">Close</button>
        </form>
    </div>

    <div class="navbar">
        <a style="text-decoration:none" href="main.php"><p class="mv">Movies</p></a>
        <a style="text-decoration:none" href="main.php?section=Actor"><p class="ac ">Actors</p></a>
        </div>
        <?php
        if (isset($_POST["searchTerm"]))
            $realtitle = $_POST["searchTerm"];
        
        if (isset($_POST["category"]))
            $category = $_POST["category"];
        ?>

        <div class="content" style="height:70vh">
            <h1>Movies and Actors</h1>
            <br>
            <br>
            <?php

            $db_host = "mysql.cs.nott.ac.uk";
            $db_user = 'psymk6_COMP1004'; // change 
            $db_pass = 'RRYNKS'; // change me
            $db_name = 'psymk6_COMP1004'; // change me


            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
            if ($conn->connect_errno)  die("failed to connect to database\n</body>\n</html>"); 

            if($category=="mvTitle" || $category == "mvGenre"){
                $sql="SELECT mvID,actID,mvTitle,mvPrice,mvGenre,mvYear FROM Movie WHERE $category LIKE '%$realtitle%' ";
            }
            else{
                $sql="SELECT m.mvID,m.actID,m.mvTitle,m.mvPrice,m.mvGenre,m.mvYear FROM Actor 
                    JOIN Movie AS m ON m.actID = Actor.actID WHERE Actor.actName LIKE '%$realtitle%' ";
            }
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->bind_result($ID, $actID, $Title, $Price, $Genre,$Year );
            ?>
            <button class = "iconbutton" onclick="toggleSearchPanel('movie')"><img  alt="edit" src="svg\search.svg"></button>
            <h2>Search Results for '<?php echo $realtitle; ?>' </h2>
            <br>
            <br>
            <?php
            $stmt->store_result();
            if( $stmt->num_rows > 0 ){   
                echo '<table width="750" border="1" cellpadding="1" cellspacing="1">';
                    echo '<tr> <th>ID</th> <th>Lead Actor ID</th> <th>Title</th> <th>Price</th> <th>Genre</th><th>Year</th> </tr>';

                    while($stmt->fetch()){
                    echo "<tr>";
                    echo "<td>". htmlentities($ID) ."</td>";
                    echo "<td>". htmlentities($actID) ."</td>";
                    echo "<td>". htmlentities($Title) ."</td>";
                    echo "<td>£". htmlentities(round($Price,2)) ."</td>";
                    echo "<td>". htmlentities($Genre) ."</td>";
                    echo "<td>". htmlentities($Year) ."</td>";
                    echo "</tr>";
                    }
                echo '</table>';
            }
            else{
                echo '<h3>No results...</h3>';
            }
            ?>
            <br><a href="main.php"><button class = "backbutton">Go back</button></a>
            <br>
            <br>
            <u><h4>Use <span><img  alt="edit" src="svg\search.svg"></span> to search</h4></u>
        </div>
    </body>
</html>