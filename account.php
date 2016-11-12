<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.

merging with master
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Account Information</title>
    </head>
    <body>
        <?php 
        require "./user_menu.php";
        
        echo "<h1>Account</h1>";
        echo "<h2>";
        print session_id();
        echo "</h2>"; 
        
        echo "<p>Coming soon!</p>";
        
        var_dump($_SESSION); // #DEBUG
        

        ?>
        <p><a href='welcome.php'>Return to catalog</a></p>
    </body>
</html>
