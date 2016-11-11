<?php

// Function of if-statements that tests the validity of the user's inputted values (FOR INVOICE)
//credit code: Prof. Kazman
function validate_quantity($value) {
    // To ensure that $value is a valid price
    if (!isset($errors_array)) {
        $errors_array = array(); // initial array if not defined already
    }
    // checks if inputted value was numeric or not
    if (!is_numeric($value)) {
        $errors_array['not_number'] = "Not Numeric";
    }
    // checks to ensure value was a positive number
    if ($value < 0) {
        $errors_array['not_non-negative'] = "Quantity Cannot Be Negative"; 
    }
    //checks to make sure value is an integer
    if ($value - (int) $value != 0) {
        $errors_array['not_integer'] = "Must Be An Integer";
    }
    return $errors_array;
}

// Creating the quantity errors function
function quantity_errors_str($errors_array) {
    $error_string = "<br>" . implode('<br>', $errors_array); // Returns the certain type of error

    return $error_string;
}

// function that allows user to create an account
function create_new_user($user_login, $users_array) {
    $fp = fopen($user_login, 'a');
    fputs($fp, "\n" . implode(', ', $users_array));

    fclose($fp);
}

// Get existing user credentials
// $user_login - the file with user log in info
function get_users_creds($username_entered, $user_login) {
// Read file & create users info arrays    
    if (file_exists($user_login)) {
        $fp = fopen($user_login, 'r');
        while (!feof($fp)) {
            $users_line = fgets($fp);
            if (!empty($users_line)) {
                $users_key = explode(', ', $users_line);
                if ($users_key[0] == $username_entered) {
                    $users_array = array('username' => $users_key[0], 'password' => $users_key[1], 'email' => $users_key[2]);
                    $all_users_array[$users_array['username']] = $users_array;
                    return $all_users_array;
                }
            }
        }
        fclose($fp);
        return array();
    }
    die("Filename $user_login does not exist! Exiting.");
}
// Get existing user information (without login information)
// $user_login - the file with user log in info
function get_users_info($username_entered, $user_login) {
// Read file & create users info arrays    
    if (file_exists($user_login)) {
        $fp = fopen($user_login, 'r');
        while (!feof($fp)) {
            $users_line = fgets($fp);
            if (!empty($users_line)) {
                $users_key = explode(',', $users_line);
                if ($users_key[0] == $username_entered) {
                    $users_array = array('username' => $users_key[0], 'email' => $users_key[2], 'first_name' => $users_key[3],'last_name' => $users_key[4] );
                    $all_users_array[$users_array['username']] = $users_array;
                    return $all_users_array;
                }
            }
        }
        fclose($fp);
        return array();
    }
    die("Filename $user_login does not exist! Exiting.");
}

//advanced forms powerpoint
function make_textbox_sticky($name_of_textbox) {
    if (isset($_POST[$name_of_textbox])) {
        echo $_POST[$name_of_textbox];
    } else {
        echo '';
    }
}

?>
