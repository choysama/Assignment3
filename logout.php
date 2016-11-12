<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>User logged out</title>
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>
        <?php
        
        // if user does not have a cookie, redirect to login page
        if ( !isset($_COOKIE["userid"]) ) { 
            header ('Location: index.php');
        }
        
        // if user has a cookie
        else {
            // Check if user is logged in
            $username = $_COOKIE["userid"];
            session_save_path("./sess");
            session_id($username); 
            session_start();
            
            // If the user is not logged in, redirect them to the log in page
            if ( $_SESSION["logged_in"] === false) {
               header ('Location: index.php');
            }
            // Else, if the user is logged in, log them out and destroy both the session and the cookie
            else {
                $_SESSION['logged_in'] = false;
                
                // Delete cookie and destroy session
                setcookie ("userid", "", time() - 3600);
                $_SESSION = array();    

                session_destroy();
            }    
        }
        echo "<h1>Please come again!</h1>";
        ?>
        
        <p><a href='index.php'>Return to login</a></p>
        
    </body>
</html>
