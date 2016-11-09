<?php

/* 
    File name  : CatalogMgmt.php
    Created on : November 2, 2016
    Author     : Samantha Choy
    Purpose    : Assignment 2 for ITM 352
 *               Separate file to store functions
 */


/**
 * Returns a type of array depending on whether or not there 
 * exist headers. An indexed array will be outputted if there
 * are no headers. An associative array will be outputted if 
 * there are headers. 
 * <p>
 * If hasHeader is true, the function will treat the first line
 * in the file as headers. These headers will be used as keys 
 * to access the associative array. If hasHeader is false, the 
 * data will be put into an indexed array. 
 * <p>
 * This function assumes that each piece of data is on its own
 * line and that there are more than one line in the file. 
 *
 * @param  filename  string value that is the name of the file
 * @param  delimiter character used to delimit data in the file]
 * @param  hasHeader boolean value indicating the existence of headers 
 *          on the first line of the file
 * @return      an indexed array (if the data has no headers) or an associative array (if the data does have headers)
 */
function fileToArray($filepath, $delimiter, $hasHeader) {
    // Variable Initialization
    
    // Check if the file exists
    if ( file_exists($filepath) ) {
        
        // check if file is not empty and has non-whitespace characters
         $size = filesize($filepath);
         if ( $size == 0 || trim( file_get_contents($filepath) ) == false ) {
             /*
            $section = file_get_contents($filepath, NULL, NULL, 0, 50)
            $cleanedstr = preg_replace(
                                "/(\t|\n|\v|\f|\r| |\xC2\x85|\xc2\xa0|\xe1\xa0\x8e|\xe2\x80[\x80-\x8D]|\xe2\x80\xa8|\xe2\x80\xa9|\xe2\x80\xaF|\xe2\x81\x9f|\xe2\x81\xa0|\xe3\x80\x80|\xef\xbb\xbf)+/",
                                "_",
                                $str
                            );
              * 
              */
             $data = null;
             echo "Error: File is empty";
         }
        
        else {
            // Send the data into an indexed array since the file has no headers
            if ($hasHeader == false) {
                $fp = fopen($filepath, 'r'); 


                $i = 0; // varriable for putting data into array

                while( $line_in = fgetss($fp, $size) ) {
                    $data[$i] = explode($delimiter, $line_in);

                    // Strip whitespace from end of last element in indexed array
                    $last_index = count($data[$i]) - 1;
                    $temp_str = rtrim($data[$i][$last_index]);
                    $data[$i][$last_index] = $temp_str;

                    $i++;
                }

                fclose($fp); 
            }

            // Send the data into an associative array using the file headers as the keys
            else if ($hasHeader == true) {
                $fp = fopen($filepath, 'r'); 

                $i = 0; // varriable for putting data into array

                // Retrieve headers
                $line_in = fgetss($fp, $size);
                $headers = explode($delimiter, $line_in);

                // Strip whitespace from end of last element in array
                $last_index = count($headers) - 1;
                $temp_str = rtrim($headers[$last_index]);
                $headers[$last_index] = $temp_str;
                $last_a_key = $headers[$last_index];

                // Put data into associative array using headers
                while( $line_in = fgetss($fp, $size) ) {
                    $temp_data = explode($delimiter, $line_in);

                    // Send data from temporary indexed array into associative array
                    $data[$i] = array_combine($headers, $temp_data);

                    // Strip whitespace from end of last element in associative array
                    $temp_str = rtrim($data[$i][$last_a_key]);
                    $data[$i][$last_a_key] = $temp_str;

                    $i++;
                }

                fclose($fp); 

            }
            else {
                echo "An error has occurred with parsing the data. Exiting the program.";
                $data = null;
            }
        }
    }
    
    else {
        echo "Error: File does not exist.";
        $data = null;
    }
        
        
    return $data;
}

// sends array to a file with the indiciated delimiter, 
// file with name $filename will be overwritten
// Assumes array is 2 dimensional with an outer indexed array 
// and inner associative array
// return T/F?
function arrayToFile($in_array, $delimiter, $filepath, $hasHeader) {
    // Variable initialization
    $text = "";
    $passedFirstElement = false;
    
    // Check if $in_array is set
    if (!isset($in_array)) {
        echo "Error: Array is not set"; 
        return false; 
    }
    
    else {
        if ( empty($in_array) ) {
            echo "Error: Array is empty"; 
            return false;
        }
        else {
            if ($fp = fopen($filepath, "w")) {

                // Append headers to $text
                // Assumes the keys to be headers

                if ($hasHeader == true) {
                    $passedFirstElement = false;

                    // print values with delimiter
                    foreach ($in_array[0] as $key => $value) {
                        if ($passedFirstElement == false) {
                            $text .= $key;

                            $passedFirstElement = true;
                        }
                        else { 
                            $text .= $delimiter . $key;
                        }
                    }
                    $text .= "\n";
                }

                // Append data into $text
                // Append row
                for ($row = 0; $row < count($in_array); $row++) {
                    $passedFirstElement = false;

                    // print values with delimiter
                    foreach ($in_array[$row] as $key => $value) {
                        if ($passedFirstElement == false) {
                            $text .= $in_array[$row][$key];

                            $passedFirstElement = true;
                        }
                        else { 
                            $text .= $delimiter . $in_array[$row][$key];
                        }
                    }
                    $text .= "\n";
                }    

                fputs($fp, $text);

                fclose($fp);  
            }
            else {
                echo "Unable to write array to $filepath";
                return false; 
            }
        }    
    }
}

?>
