<!doctype html>
<html>
    <head>
        <title>Guitar Wars - High Scores</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h2>Guitar Wars - Add Your High Score</h2>
        <?php
            require_once('appVars.php');
            require_once('connectVars.php');
            if(isset($_POST['submit'])){
                //Get the score data from POST
                $name = $_POST['name'];
                $score = $_POST['score'];
                $screenshot = $_FILES['screenshot']['name'];
                $screenshot_type = $_FILES['screenshot']['type'];
                $screenshot_size = $_FILES['screenshot']['size'];

                if(!empty($name)&&!empty($score)&&!empty($screenshot)){
                    if((($screenshot_type == 'image/gif')|| ($screenshot_type == 'image/jpeg') ||
                    ($screenshot_type == 'image/pjpeg') || ($screenshot_type == 'image/png')) &&
                    ($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE)){
                        if($_FILES['screenshot']['error']==0){
                            //move the file to the target upload folder
                            $target = GW_UPLOADPATH . $screenshot;
                            if(move_uploaded_file($_FILES['screenshot']['tmp_name'],$target)){

                                    //connect to the database
                                $dbc = mysqli_connect( DB_HOST ,DB_USER,DB_PASSWORD,DB_NAME);

                                //Write to the database
                                $query = "INSERT INTO guitarwars VALUES(0,NOW(),'$name','$score','$screenshot')";
                                mysqli_query($dbc,$query);

                                //Confirm success
                                echo '<p>Thanks for adding your new high score!</p>';
                                echo '<p><strong>Name: </strong>' . $name . '<br>';
                                echo '<strong>Score: </strong>' . $score . '<br>';
                                echo '<img src="'.GW_UPLOADPATH. $screenshot.'" alt="Score image"></p>';
                                echo '<p><a href="index.php">&lt;&lt; Back to high scores</a></p>';

                                //Clear the score data to clear the form
                                $name = "";
                                $score = "";

                                mysqli_close($dbc);
                            }
                            else{
                                echo '<p class="error">There was an error uploading your image.</p>';
                            }
                        }
                    }

                    else{
                        echo '<p class = "error">The screenshot must be a GIF, JPEG, or PNG image file'. 
                        ' no greater than '. (GW_MAXFILESIZE/1024) .' KB in size.</p>';
                    }

                    //Try to delete the temporary screen shot image file
                    @unlink($_FILES['screenshot']['tmp_name']);
                }

                else{
                    echo '<p class ="error">Please enter all of the information to add ' .
                    'your high score.</p>';
                }
            }
        ?>
        <hr>
        <form enctype="multipart/form-data" method = "POST" action = "<?php echo $_SERVER['PHP_SELF']; ?>">
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