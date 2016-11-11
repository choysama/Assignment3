<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.

branching test
now I will test merging this branch
-->

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
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
            if ( $_SESSION['logged_in'] == false) {
                header ('Location: index.php');
            }
            // Else, if the user is logged in, print out links for their navigation
            else if ( $_SESSION['logged_in'] == true ) {
                echo "Welcome, " . $_SESSION['first_name'] . "! ";
                echo " <a href='logout.php'>logout</a> ";
                echo " Account ";
                echo " Cart(" . count( $_SESSION['cart'] ) . ")";
                echo "<br>";
                
                var_dump($_SESSION); // $DEBUG
            }  
            else {
                echo "what?"; // #DEBUG
            }
        }
            {
            // get cookie
            // start session
            
            // logout link redirects to logout page and deletes cookie
        }
        ?>

