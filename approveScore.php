<!doctype html>
<?php
    require_once('authorize.php');
?>
<html>
    <head>
        <title>Guitar Wars - Approve High Score</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        <h2>Guitar Wars -Approve a High Score</h2>
        <?php
            require_once('appVars.php');
            require_once('connectVars.php');

            if(isset($_GET['id']) && isset($_GET['date']) && isset($_GET['name']) &&
                isset($_GET['score']) && isset($_GET['screenshot']) ){

                    //Get the score data from the GET 
                    $id = $_GET['id'];
                    $date = $_GET['date'];
                    $name = $_GET['name'];
                    $score = $_GET['score'];
                    $screenshot = $_GET['screenshot'];
            }

            else if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['score']) ){
                //Get the score data from POST 
                $id = $_POST['id'];
                $name = $_POST['name'];
                $score = $_POST['score'];
            }
            else{
                echo '<p class = "error"> Sorry, no high score was specified for approval.</p>'; 
            }

            if(isset($_POST['submit'])){
                if($_POST['confirm'] == 'Yes'){
                    

                    //connect to the database
                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                    //Approve the score by setting the approved column in the database
                    $query = "UPDATE guitarwars SET  approved=1 WHERE id='$id'";

                    mysqli_query($dbc, $query);
                    mysqli_close($dbc);

                    //confirm success with the user 
                    echo '<p> The high score of ' . $score .' for ' . $name .
                    ' was successfully approved.</p>';
                }
                else{
                    echo '<p class = "error"> Sorry, there was a problem approving the high score.</p>';
                }
            }

            else if(isset($id) && isset($name) && isset($date) && isset($score) && isset($screenshot)){
                echo'<p>Are you sure you want to approve the following high score?</p>';
                echo '<p><strong>Name: </strong>'.$name.'<br><strong>Date: </strong>'.$date.
                '<br><strong>Score: </strong>'.$score.'</p>';
                echo'<form method="POST" action="approveScore.php">';
                echo '<input type="radio" name="confirm" value="Yes">Yes';
                echo'<input type="radio" name="confirm" value="No" checked="checked">No<br>';
                echo'<input type="submit" value="Submit" name="submit">';

                echo '<input type="hidden" name="id" value="'.$id.'" >';

                echo'<input type="hidden" name="name" value="'.$name.'">';
                echo '<input type="hidden" name="score" value="'.$score.'">';
                echo '</form>';
            }
            echo '<p><a href="admin.php">&lt;&lt;Back to the admin page</a></p>';
        ?>
    </body>
</html>