<head>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <h1> Log in! </h1>
    Please log in to proceed to our online store. 
</head>

<?php

// Include functions created in functions.php file
include './util/functions.php';

// Using user info from user_login.dat file
$user_file = './data/user_login.dat';

$is_logged_in = FALSE;

// File I/O



// Check to see if user is trying to login, see if they're already a registered user
        if (array_key_exists('login_submit', $_POST)) {
            echo "<div id='error'>"; //div to modify how error is displayed
            
            $username_entered = strtolower($_POST['username']);
            $all_users_array = get_users_creds($username_entered, $user_file);
// Make username case insensitive, convert $_POST['username'] to all uppercase  or all lowercase
            if (array_key_exists($username_entered, $all_users_array)) {
                // check to see if password matches the users info
            $user_info = $all_users_array[$username_entered];
            
                // Send user to next page if credentials are valid
                if ($user_info['password'] == $_POST['password']) {
                    $is_logged_in = TRUE;
                    
              
                    //since there are no errors, issue a cookie, set session variables, and send to welcome page
                    // assumes the cookie has not been set
                                       
                    $user_info = get_users_info($username_entered, $user_file);          
                    
                    setcookie("userid", $username_entered, time()+3600 ); 
                    session_save_path("./sess");
                    session_id($username_entered); 
                    session_start();
                    $_SESSION['logged_in'] = true;
                    $_SESSION['first_name'] = $user_info[$username_entered]['first_name'];
                    $_SESSION['last_name'] = $user_info[$username_entered]['last_name'];
                    $_SESSION['cart'] = array();
                    

                    header ('Location: welcome.php');
                }
                
                // User entered the wrong password
                else {
                    print "Username and password do not match. Please try again.";
                    $is_logged_in = FALSE;
                }
            }
            // username doesn't exist
            else {
                print "$username_entered doesn't exist. Please try again.<br>";
            }
            
            echo "</div>"; //div to modify how error is displayed
            
        }
        if ($is_logged_in == FALSE) {

        ?>
        <center>
            <form action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING']; ?>' method= 'post'>
                Username: <br>
                <INPUT TYPE="TEXT"  name="username" value = "<?php if ( isset($_POST['username']) ) echo $_POST['username'] ?>"><br><br>
        Password: <br>
        <INPUT TYPE="password" name = 'password' value ="<?php if (isset($_POST['password'])) echo $_POST['password']?>"><br><br>
        <INPUT TYPE="SUBMIT" name = 'login_submit' value="Login"> <br><br><br>   
        <INPUT TYPE="SUBMIT" name='create_new_user' value='Create Account'>
        <p><a href="welcome.php">Go to products (this link will be gone once testing is done)</a></p>
    </form>
</center>

    <?php
    
        if (array_key_exists('create_new_user', $_POST)) {
            header('Location: registration.php?' . $qstr);
        }
    }
?>