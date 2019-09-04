<?php
        //user name and password 
        $userName = 'rock';
        $password = 'roll';

        if(!isset($_SERVER['PHP_AUTH_USER'])||!isset($_SERVER['PHP_AUTH_PW'])||
        ($_SERVER['PHP_AUTH_USER'] !=$userName)||($_SERVER['PHP_AUTH_PW'] !=$password)){
            // The user name and or password are incorrect 
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Basic realm = "Guitar Wars"');
            exit('<h2>Guitar Wars</h2> Sorry, you must enter a valid user name and password to ' . 
            'access this page.');
        }
?>