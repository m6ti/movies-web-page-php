<html>
    <head>
        <meta charset="utf-8">
        <title> Actors Search Result</title>
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript" src="scrip2.js"></script>
    </head>
    <body>

    <div class="search-panel" id="search-panel-actor">
        <form action="searchAc.php" method="POST" onsubmit="return validateSearch(this)">
            <label for="searchTerm">Search for actor name: </label>
            <input type="text" id="searchTerm" name="searchTerm">
            <button type="submit">Submit</button>
            <button type="button" class="backbutton" onclick="toggleSearchPanel('actor')">Close</button>
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

            $sql="SELECT Actor.actID, Actor.actName , Movie.mvTitle FROM Actor JOIN Movie 
                ON Actor.actID = Movie.actID WHERE Actor.actName LIKE '%$realtitle%' GROUP BY Actor.actName ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $stmt->bind_result($actID, $actName,$movie);
            ?>
            <h2>Search Results for '<?php echo $realtitle; ?>' </h2>
            <button class = "iconbutton" onclick="toggleSearchPanel('actor')"><img  alt="edit" src="svg\search.svg"></button>
            <br>
            <br>
            <?php
            $stmt->store_result();
            if( $stmt->num_rows > 0 ){  
                echo '<table width="750" border="1" cellpadding="1" cellspacing="1">';
                    echo '<tr> <th>Actor ID</th> <th>Actor Name</th><th>Featured Movie</th> </tr>';

                    while($stmt->fetch()){
                    echo "<tr>";
                    echo "<td>". htmlentities($actID) ."</td>";
                    echo "<td>". htmlentities($actName) ."</td>";
                    echo "<td>". htmlentities($movie) ."</td>";
                    echo "</tr>";
                    }
                    
                echo '</table>';
            }
            else{
                echo '<h3>No results...</h3>';
            }
            ?>
            <br>
            <a href="main.php?section=Actor"><button class = "backbutton">Go back</button></a>
            <br>
            <u><h4>Use <span><img  alt="edit" src="svg\search.svg"></span> to search</h4></u>
        </div>
    </body>
</html>