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
            //connect to the database
            $dbc = mysqli_connect('local','root','','gwdb')
            or die('Error connecting to MYSQL server');

        //get the score data from mysqli
            $query = "SELECT * FROM guitarwars";
            $data = mysqli_query($dbc,$query)
            or die('Error querying database');

//Loop through the array of score data and format it as HTML
            echo '<table>';
            while($row=mysqli_fetch_array($data)){
                //Display the score data
                echo '<tr> <td class="scoreInfo">';
                echo '<span class="score">'. $row['score']. '</span><br>';
                echo '<strong>Name</strong> ' . $row['name'] . '<br>';
                echo '<strong>Date:</strong> ' . $row['date'] . '</td>';
                if(is_file($row['screenshot']) && filesize($row['screenshot'])>0){
                    echo '<td><img src="'. $row['screenshot'] . '"alt="Score image"></td></tr>';
                }
                else{
                    echo '<td><img src="unverified.gif" alt="Unverified score"></td></tr>';
                }
            }
            echo '</table>';

            mysqli_close($dbc);
        ?>

    </body>
</html>