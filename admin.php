<!doctype html>
<?php
        //user name and password 
        $userName = 'rock';
        $password = 'roll';

        if(!isset($_SERVER['PHP_AUTH_USER'])||!isset($_SERVER['PHP_AUTH_PW'])||
        ($_SERVER['PHP_AUTH_USER'] !=$userName)||($_SERVER['PHP_AUTH_PW'] !=$password)){
            // The user name and or password are incorrect 
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Basic realm = "Guitar Wars"');
            exit('<h2>Guitar Wars</h2> Sorry, you must enter a valid user name and password to' . 
            'access this page.');
        }
?>
<html>
    <head>
        <title>Admin Pae</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h2>Guitar Wars - High Scores Administration</h2>
        <p>Below is a list of all Guitar Wars high scores. Use this page to remove scores as needed.</p>
        <hr>

        <?php
            require_once('appVars.php');
            require_once('connectVars.php');

            //connect to database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

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