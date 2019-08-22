<!doctype html>
<html>
    <head>
        <title>
            Guitar Wars-High Scores
        </title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    
    <body>
        <h2>Guitar Wars - High Scores</h2>
        <p>Welcome, Guitar Warrior, do you have what it takes to crack the high score list? If so, just
        <a href="addScore.php">add your own score</a>.</p>
        <hr>

        <?php
            require_once('appVars.php');
            require_once('connectVars.php');
            //connect to the database
            $dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
            or die('Error connecting to MYSQL server');

        //get the score data from mysqli
            $query = "SELECT * FROM guitarwars ORDER BY score DESC";
            $data = mysqli_query($dbc,$query)
            or die('Error querying database');

//Loop through the array of score data and format it as HTML
            echo '<table>';
            $i = 0;
            while($row=mysqli_fetch_array($data)){
                //Display the score data
                //may not work in google chrome
                if($i==0){
                    echo '<tr><td colspan = "2" class = "topScoreHeader"> Top Score: ' 
                    .$row['score']. '</td></tr>';
                }
                echo '<tr> <td class="scoreinfo">';
                echo '<span class="score">'. $row['score']. '</span><br>';
                echo '<strong>Name</strong> ' . $row['name'] . '<br>';
                echo '<strong>Date:</strong> ' . $row['date'] . '</td>';
                if(is_file(GW_UPLOADPATH . $row['screenshot']) && filesize(GW_UPLOADPATH . $row['screenshot'])>0){
                    echo '<td><img src="'. GW_UPLOADPATH . $row['screenshot'] . '"alt="Score image"></td></tr>';
                }
                else{
                    echo '<td><img src="'. GW_UPLOADPATH . 'unverified.gif' . '"alt="Unverified score">
                    </td></tr>';
                }
                $i++;
            }
            echo '</table>';

            mysqli_close($dbc);
        ?>

    </body>
</html>