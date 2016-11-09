<?php
    include 'functions.php';
    
    /*#DESIGNHOLE
     * Issue: Sam doesn't like how errors are displayed 
     */


    $user_file = 'user_login.dat';
    //start off as if user is not logged in (that's why they're at registration page & with no errors, because nothing was entered yet
    $is_logged_in = false;
    $errors = array();
    //if they pressed the register or continue button, validate entered info
    if (array_key_exists('register_valid', $_POST) || array_key_exists('error_continue', $_POST)) {

        // Define variables and set to empty values
        /*#FUNCTIONALITYHOLE
         * Issue: username is case-sensitive. It's supposed to be case-INsensitive.
         */
        $username_entered = $password_entered = $confirmed_password = $email_entered = "";
        $username_entered = $_POST['username'];
        $all_users_info = get_users_info($username_entered, $user_file);
        //convert username to lowercase to make it case-insensitive
        $_POST['username'] = strtolower($_POST['username']);
        // username required error
        if (empty($_POST['username'])) {
            $errors['username']['field_required'] = "Username required.";
        }
        // check to see if username already exists
        else {
            if (array_key_exists($username_entered, $all_users_info)) {
                $errors['username']['username_exists'] = "Error: Username already exists.";
            }
        }
        // check to see if username has illegal characters (no commas) & is correct length (3-15)
        if (!preg_match('/^\w{3,15}$/', $_POST['username'])) {
            $errors['username']['username_invalid'] = "Error: Username must be 3-15 characters long & consist only of letters and numbers.";
        }

        $password_entered = $_POST['password'];

        // password required error
        if (empty($_POST['password'])) {
            $errors['password']['field_required'] = "Password required.";
        } else {
            // check to see if password is at least 5 characters
            if (strlen($_POST['password']) < 5) {
                $errors['password']['password_length'] = "Error: Password must have a minimum of 5 characters.";
            }
        }
        // confirm password required
        if (empty($_POST['confirm_password'])) {
            $errors['confirm_password']['field_required'] = "Confirm password.";
        } else {
            // check to see if password has a comma 
            $confirmed_password = $_POST['confirm_password'];

        // make sure password is case sensitive & both passwords entered match   
            $password1 = $_POST['password'];
            $password2 = $_POST['confirm_password'];
            if ($password1 != $password2) {
                $errors['confirm_password']['passwords_dont_match'] = "Error: Passwords do not match.";
            }
        }

        $email_entered = $_POST['email'];
        // email required error
        if (empty($_POST['email'])) {
            $errors['email']['field_required'] = "Email required.";
        } else {
            // make sure email is case insensitive
            $email_entered = strtolower($email_entered);
            //disregarding illegal characters from email user has entered
            if (!filter_var($email_entered, FILTER_VALIDATE_EMAIL)) {
                $errors['email']['email_invalid'] = "Error: Invalid email format.";
            } else {
                
            }
        }

        //if there are no errors, save username and password to files
        if (empty($errors)) {
            // save the registration data
            $new_user_info = array('username' => $username_entered, 'password' => $password_entered, 'email' => $email_entered);
            create_new_user($user_file, $new_user_info);
            $is_logged_in = true;
            //once this is saved and they pressed the register or continue button, go to success page 
            if (array_key_exists('register_valid', $_POST) || array_key_exists('error_continue', $_POST)) {
                ?>
                <center>
                    <td><h1>Your account has been created. Select "Continue" to review your invoice.</h1></td>
                    <form action='<?php echo 'invoice.php?' . $_SERVER['QUERY_STRING'] . '&username=' . $username_entered; ?>' method="post">
                        <input type="submit" name='validated' value='Continue'>
                    </form></center>
                <?php
            }
        }
    }

// display registration form if errors array is not empty
    if ($is_logged_in == FALSE) {
        ?>
    <h1><center>Please fill out information below to register:</center></h1>
        <style>
        body {background-color: seashell}
        </style>
        <center>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']) ?>" method="POST">
            <input type=hidden name='serial_post' value='<?php echo @$_POST['serial_post']; ?>'>
            <input type=hidden name='htmlspecialchars' value='<?php echo @$_POST['htmlspecialchars']; ?>'>
            Username: <input type="text" name="username" value="<?php make_textbox_sticky('username')?>"/>
                             <?php
                             if (isset($errors['username'])) {
                                 print implode('<br>', $errors['username']);
                             }
                             ?>
            <br>
            <br>
            Password: <input type="password" name="password"/>
            <?php
            if (isset($errors['password'])) {
                print implode('<br>', $errors['password']);
            }
            ?>
            <br>
            <br>
            Re-enter Password: <input type="password" name="confirm_password"/>
            <?php
            if (isset($errors['confirm_password'])) {
                print implode('<br>', $errors['confirm_password']);
            }
            ?>
            <br>
            <br>
            Email: <input type="email" name="email" value="<?php make_textbox_sticky('email') ?>"/>
            <?php
            if (isset($errors['email'])) {
                print implode('<br>', $errors['email']);
            }
            ?>
            <br>
            <br>
            <?php
            if (array_key_exists('register_valid', $_POST) || array_key_exists('error_continue', $_POST)) {
                ?>
                <input type="submit" name="error_continue" value="Continue">
                <?php
            } else {
                ?>
                <input type="submit" name="register_valid" value="Register">
            </form>
        </center>
            <?php
        }
    }
    ?>
</html>