<!doctype html>
<html>
    <head>
        <title>Admin Pae</title>
    </head>
    <body>
        <?php
            require_once('appVars.php');
            require_once('connectVars.php');

            //connect to database
            $dbc = msqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            //Get the score data from MYSQL
            $query = "SELECT * FROM guitarwars ORDER BY score DESC, date ASC";
            $data = mysqli_query($dbc,$query);

            //Loop through the array of score data, formatting it as html
            echo '<table>';
            while($row = mysqli_fetch_array($data)){
                //Display the score date
                echo '<tr class="scorerow"><td><strong>' . $row['name'] . '</strong></td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['score'] . '</td>';
                echo '<td><a href="removeScore.php?id=' . $row['id'] . '&amp;date=' . $row['date'] . 
                '&amp;name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;screenshot=' . 
                $row['screenshot'] . '"> Remove</a></td></tr>';

            }
            echo '</table>';
            mysqli_close($dbc);
        ?>
    </body>
</html>