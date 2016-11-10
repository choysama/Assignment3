
<?php

/*#SECURITYHOLE
 * Issue: using GET
 */
?>

<head>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
<center>
    <h1> Log in! </h1>
</center>
</head>

<?php

// Include functions created in functions.php file
include 'functions.php';

// Using user info from user_login.dat file
$user_file = 'user_login.dat';

$is_logged_in = FALSE;
$users = array();

// File I/O



// Check to see if user is trying to login, see if they're already a registered user
        if (array_key_exists('login_submit', $_POST)) {
            $username_entered = strtolower($_POST['username']);
            $all_users_array = get_users_info($username_entered, $user_file);
// Make username case insensitive, convert $_POST['username'] to all uppercase  or all lowercase
            if (array_key_exists($username_entered, $all_users_array)) {
                // check to see if password matches the users info
            $user_info = $all_users_array[$username_entered];
                if ($user_info['password'] == $_POST['password']) {
                    print "logged in as $username_entered<br>";
                    $is_logged_in = TRUE;
                    //since there are no errors, go to invoice page
                    header ('Location: invoice.php?' . $qstr . '&username=' . $_POST['username']);
                }
                else {
                    print "wrong password, try again.";
                    $is_logged_in = FALSE;
                }
            }
            // username doesn't exist
            else {
                print "$username_entered doesn't exist. Please try again.<br>";
            }
        }
        if ($is_logged_in == FALSE) {

        ?>

    <style>
        body {background-color: seashell}
    </style>
        <center>
            <form action = '<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']; ?>' method= 'post'>
                Username: <br>
                <INPUT TYPE="TEXT"  name="username" value = "<?php if (isset($_POST['username'])) echo $_POST['username'] ?>"><br><br>
        Password: <br>
        <INPUT TYPE="password" name = 'password' value ="<?php if (isset($_POST['password'])) echo $_POST['password']?>"><br><br>
        <INPUT TYPE="SUBMIT" name = 'login_submit' value="Login"> <br><br><br>   
        <INPUT TYPE="SUBMIT" name='create_new_user' value='Create Account'>
    </form>
</center>

    <?php
    
        if (array_key_exists('create_new_user', $_POST)) {
            header('Location: registration.php?' . $qstr);
        }
    }
?>