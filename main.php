<!DOCTYPE html>
<html>

<head>
    <title>My Movies</title>
    <link REL="stylesheet" TYPE='text/css' href="styles.css">
    <script type="text/javascript" src="scrip2.js"></script>
</head>
<body>
    <div class="navbar">
        <p class="mv" onclick="myFunctionMovies()">Movies</p>
        <p class="ac" onclick="myFunctionActors()">Actors</p>
    </div>

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

    <div class="search-panel" id="search-panel-actor">
        <form action="searchAc.php" method="POST" onsubmit="return validateSearch(this)">
            <label for="searchTerm">Search for actor name: </label>
            <input type="text" id="searchTerm" name="searchTerm">
            <button type="submit">Submit</button>
            <button type="button" class="backbutton" onclick="toggleSearchPanel('actor')">Close</button>
        </form>
    </div>

    <div class="content movies-container" id="movies-container">
        <h1>Movies</h1> 
        <button class = "iconbutton" onclick="toggleSearchPanel('movie')"><img  alt="edit" src="svg\search.svg"></button>
        <br>

        <?php
        $db_host = "mysql.cs.nott.ac.uk";
        $db_user = 'psymk6_COMP1004'; // change me
        $db_pass = 'RRYNKS'; // change me
        $db_name = 'psymk6_COMP1004'; // change me

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_errno)
            die("failed to connect to database\n</body>\n</html>"); 

        //Select data from movie table, and join actor on actor id to find lead actor name.
        $sql="SELECT Movie.mvID,Movie.mvTitle,Movie.mvPrice,Movie.mvGenre,Actor.actName,Movie.mvYear
            FROM Movie JOIN Actor ON Actor.actID = Movie.actID";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result( $MovieID,$Title, $Price, $Genre, $CorActor,$Year);
        ?>

        <table width="800" border="1" cellpadding="1" cellspacing="0" style="text-align: left">
            <tr> <th><h3>Title</h3></th> <th><h3>Top Actor</h3></th> <th><h3>Genre</h3></th> <th><h3>Price</h3></th>
                <th><h3>Year</h3></th> <th><h3>Movie ID</h3></th> </tr>

            <?php
            while($stmt->fetch()){
                echo "<tr>";
                echo "<td>". htmlentities($Title) ."</td>";
                echo "<td>". htmlentities($CorActor) ."</td>";
                echo "<td>". htmlentities($Genre) ."</td>";
                echo "<td>£". htmlentities(round($Price,2)) ."</td>";
                echo "<td>". htmlentities($Year) ."</td>";
                echo "<td>". htmlentities($MovieID) ."</td>";
                // update and delete icons
                echo '<td  style="width:20px"><form method = "GET" action="editMv.php"><input type="hidden" name="id" 
                    value="'.$MovieID.'"></input><button class ="iconbutton" onclick= "verif('.$MovieID.')"><img  alt="edit" 
                    src="svg\pencil-square.svg"></button></form></td>';
                echo '<td  style="width:20px"><form method = "GET" action="deleteMv.php"><input type="hidden" name="id" 
                    value="'.$MovieID.'"></input><button class="iconbutton" onclick= "verif('.$MovieID.')"><img alt="delete" 
                    src="svg\trash3-fill.svg"></button></form></td>';
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <a href="addMovie.php"><button class = "backbutton">Add new movie</button> </a>
        <br>
        <u><h4>Use <span><img alt="edit" src="svg\search.svg"></span> to search, <span><img alt="edit" 
            src="svg\pencil-square.svg"></span> to update the records, <span><img alt="delete" 
            src="svg\trash3-fill.svg"></span> to delete a record.</h4></u>
    </div>
    <div class="content actors-container display-none" id="actors-container">
        <h1>Actors</h1>
        <button class = "iconbutton" onclick="toggleSearchPanel('actor')"><img  alt="edit" src="svg\search.svg"></button>
        <br>

        <?php
        $db_host = "mysql.cs.nott.ac.uk";
        $db_user = 'psymk6_COMP1004'; // change me
        $db_pass = 'RRYNKS'; // change me
        $db_name = 'psymk6_COMP1004'; // change me

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($conn->connect_errno)
            die("failed to connect to database\n</body>\n</html>"); 

        $sql="SELECT Actor.actID, Actor.actName , Movie.mvTitle FROM Actor LEFT OUTER JOIN Movie ON Actor.actID = Movie.actID 
            GROUP BY Actor.actID";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result( $actid, $actname,$actfilm);
        ?>
        
        <table width="700" border="1" cellpadding="1" cellspacing="0" style="text-align: left">
            <tr> <th><h3>Actor Name</h3></th> <th><h3>Featured film</h3></th> <th><h3>Actor ID</h3></th> </tr>

            <?php
            while($stmt->fetch()){
                echo "<tr>";
                echo "<td>". htmlentities($actname) ."</td>";
                echo "<td>". htmlentities($actfilm) ."</td>";
                echo "<td>". htmlentities($actid) ."</td>";
                //update and delete icons
                echo '<td style="width:20px"><form method = "GET" action="editAc.php"><input type="hidden" name="id" value="'.$actid.'"><button class =" iconbutton" onclick= "verif('.$actid.')"><img  alt="edit" src="svg\pencil-square.svg"></button></form></td>';
                echo '<td style="width:20px"><form method = "GET" action="deleteAc.php"><input type="hidden" name="id" value="'.$actid.'"><button class =" iconbutton" onclick= "verif('.$actid.')"><img alt="delete" src="svg\trash3-fill.svg"></button></form></td>';
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <a href="addActor.php"><button class = "backbutton">Add new actor</button></a>
        <br>
        <u><h4>Use <span><img  alt="edit" src="svg\search.svg"></span> to search, <span><img  alt="edit" src="svg\pencil-square.svg"></span> to update the records, <span><img alt="delete" src="svg\trash3-fill.svg"></span> to delete a record.</h4></u>
    </div>
    <?php
        if (isset($_GET["section"])) {
            $section = $_GET["section"];
            if($section=='Actor'){
                echo "<script>myFunctionActors()</script>";
            }
        }
    ?>
</body>

</html>