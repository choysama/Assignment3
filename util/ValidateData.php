<?php

/* 
    File name  : ValidateData.php
    Created on : Oct 28, 2016
    Author     : Samantha Choy
    Purpose    : Assignment 2 for ITM 352
 *               Separate file to store functions
 */

// function from ITM352_Advanced_Forms.ppt
function validate_price($value) {  
// Ensure that $value is a valid price
   if( !isset($errors) ) 
       $errors = array();  // init array if not defined already
   if( !is_numeric($value) ) 
       $errors['not_number'] = "not numeric";
   if( $value - round($value, 2) != 0 ) 
           $errors['not_dollar'] = "not a dollar amount";
   if( $value < 0 ) 
       $errors['not_non-negative'] = "price cannot be negative";

   return $errors;
}

// function from ITM352 Example Assignment 1
// Error checking/validation function for quantities
function validate_qty($value) 
{  // Ensure that $value is a valid quantity
   if (!isset($errors)) $errors = array(); // init array if not defined already
   if (!is_numeric($value) ) $errors['not_number'] = "quantity is not numeric";
   if ($value < 0 ) $errors['not_non-negative'] = "quantity cannot be negative";
   if ($value != round($value,0)) $errors['not_integer'] = "quantity must be an integer";

   return $errors;
}

// validate string length (min only)
// doesn't count white space at the end of the string
function validate_length($string, $min_length) {
    
    $string = rtrim($string);
    
    if ( !isset($errors) ) {
        $errors = array();  // init array if not defined already
    }
    if (strlen($string) < $min_length) {
        $errors['not_long_enough'] = "string must be longer than $min_length";
    }
    
    return $errors;  
}


// Validate text alphanumeric validate_string($string, $char)
// $char is a string of acceptable characters in the string
// a = alpha, lower case; A = alpha, upper case; n = numeric; ./_ = those symbols as is, including whitespace characters
// example: validate_string($string, 'an_-');
//white space at end of str will be trimmed
function has_illegal_char($string, $validChar) {
    $string = rtrim($string);
    $legalChar = "/[^";
    
    // Set matching expression
    // Set lower case letters as legal
    if ( preg_match('/a/', $validChar) ) {
        $legalChar .= "a-z"; 
        echo "<br>" . $legalChar; //debug
    }
    // Set upper case letters as legal
    if ( preg_match('/A/', $validChar)) {
        $legalChar .= "A-Z";
        echo "<br>" . $legalChar; //debug
    }
    // Set numbers as legal
    if ( preg_match('/n/i', $validChar)) {    
        $legalChar .= "0-9"; 
        echo "<br>" . $legalChar; //debug
    }
   
    
    // Check for non-alphanumeric symbols in $char
    $symbols = preg_replace('/[a-zA-Z0-9]/', "", $validChar);
    
    if (strlen($symbols) > 0) {
        for ($i = 0; $i < strlen($symbols); $i++) {
            $legalChar .= $symbols[$i];
        }
        echo "<br>" . $legalChar; //debug
    }
    
    // close $legalChar expression
    $legalChar .= "]/";
    echo "<br>" . $legalChar; //debug
    
    // Return statement
    if ( preg_match($legalChar, $string) ) {
        return true;
    }
    else {
        return false;
    }
}


?>