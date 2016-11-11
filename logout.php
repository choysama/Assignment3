<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        // if user does not have a cookie, redirect to login page
        if ( !isset($_COOKIE["userid"]) ) { 
            //header ('Location: index.php');
        }
        
        // if user has a cookie
        else {
            // Check if user is logged in
            $username = $_COOKIE["userid"];
            session_id($username); 
            session_start();
            
            echo "started teh session for $username<BR>"; // #DEBUG
            var_dump($_SESSION); // #DEBUG

            // If the user is not logged in, redirect them to the log in page
            if ( $_SESSION['logged_in'] == false) {
               // header ('Location: index.php');
                echo "they are not logged in<BR>"; // #DEBUG
            }
            // Else, if the user is logged in, log them out and destroy both the session and the cookie
            else {
                echo "Before log out: "; // #DEBUG
                var_dump($_SESSION); // #DEBUG

                $_SESSION['logged_in'] = false;
                
                // Delete cookie
                setcookie ("userid", "", time() - 3600);
                $_SESSION = array();    
                echo "<br><br>After log out: "; // #DEBUG
                var_dump($_SESSION); // #DEBUG
                session_destroy();
                
                echo "<br><br>After log out: "; // #DEBUG
                var_dump($_SESSION); // #DEBUG
            }    
        }
        echo "<h1>Please come again!</h1>";
        ?>
        
        
    </body>
</html>
