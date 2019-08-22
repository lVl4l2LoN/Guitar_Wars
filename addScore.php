<!doctype html>
<html>
    <head>
        <title>Guitar Wars - High Scores</title>
        <link rel="stylesheets" type="text/css" href="style.css">
    </head>
    <body>
        <h2>Guitar Wars - Add Your High Score</h2>
        <?php
            if(isset($_POST['submit'])){
                //Get the score data from POST
                $name = $_POST['name'];
                $score = $_POST['score'];
                $screenshot = $_FILES['screenshot']['name'];

                if(!empty($name)&&!empty($score)){
                    //connect to the database
                    $dbc = mysqli_connect('localhost','root','','gwdb');

                    //Write to the database
                    $query = "INSERT INTO guitarwars VALUES(0,NOW(),'$name','$score','$screenshot')";
                    mysqli_query($dbc,$query);

                    //Confirm success
                    echo '<p>Thanks for adding your new high score!</p>';
                    echo '<p><strong>Name: </strong>' . $name . '<br>';
                    echo '<strong>Score: </strong>' . $score . '</p>';
                    echo '<p><a href="index.php">&lt;&lt; Back to high scores</a></p>';

                    //Clear the score data to clear the form
                    $name = "";
                    $score = "";

                    mysqli_close(dbc);
                }

                else{
                    echo '<p class ="error">Please enter all of the information to add' .
                    'you high score.</p>';
                }
            }
        ?>
        <hr>
        <form method = "POST" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="MAX_FILE_SIZE" value="32768">
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" value="<?php if(!empty($name))echo $name; ?>" ><br>

            <label for="score" >Score:</label>
            <input type = "text" id="score" name="score" value="<?php if(!empty($score))echo $score; ?>" >
            <input type="file" id="screenshot" name="screenshot">
            <hr>

            <input type="submit" value = "Add" name="submit" >

        </form>
    </body>
</html>