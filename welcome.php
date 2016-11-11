<html>
    <head>
        <meta charset="UTF-8">
        <title>Fish Market</title>
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>

<?php

// Pull array data from the file destinationdata.php
require 'user_menu.php';
require './data/products.php';
// using functions information from file functions.php
include './util/functions.php';


// Check if the user hit the send button. If so, validate the data.
//code help: Cherie Ishihara

/* #SECURITYHOLE
 * 
 * Issue: using GET instead of POST
 * 
 * #FUNCTIONALITYHOLE
 * 
 * Issue: I can't leave the final textbox empty
 */
if (array_key_exists('send', $_GET)) {
    // If the user hits send, validate the quantities.
    //text box has quantites
    $has_quantities = false;
    for ($i = 0; $i < count($products); $i++) {
        // Validate the destinations one at a time
        $quantity = $_GET['number_of_fish'];
        $the_errors = FALSE;

        // Validate the order
        $errors[$i]['order'] = validate_quantity($_GET['number_of_fish'][$i]['order']);
        if (!empty($errors[$i]['order'])) {
            $the_errors = TRUE;
        }
        
        //check each line to see 
        foreach ($quantity[$i] as $key => $a_quantity) {
            if ($a_quantity != 0 && $the_errors == FALSE) {
                $has_quantities = true;
            }
        }
    }

    //check if user entered any quantities
    if ($has_quantities == false) {
        $errors_array['no_selections'] = "<b><big style='color:red'>Error: Please enter how many fishes you would like to purchase. </big></b>";
        print $errors_array['no_selections'];
    }


    // If there are no errors and they're not logged in yet...
    $is_logged_in = FALSE;
    if ($the_errors == FALSE && $is_logged_in == FALSE && $has_quantities == TRUE) {
        // Then send to log in page
        $qstr = http_build_query(
                array (
                    'quantity' => $_GET['number_of_fish'])
                );
        header('Location: login.php?' . $qstr);
    }
}
?>

        
    <center><h1>Welcome to I'a (Fish) Market</h1>
        <p><i>Our online commerce is now selling pet fishes near you! 
            <br> Order your favorite fish and we'll deliver them to you.
            <br> Below are the 5 different types of fish that are sold via I'a Market. </i></p>

            <hr>
<!--- 

#SECURITYHOLE
Issue: action isn't using htmlspecialchar()
Issue: using GET instead of POST

---->
        <form id="feedback" method="get" action="<?php print $_SERVER['PHP_SELF']; ?>">
            <table style= border-collapse:collapse border=4>
                <tbody>
                    <tr>
                        <th style="text-align: center; width: 100px;"><b>Image</b></th>
                        <th style="text-align: center; width: 100px;"><b>Name of Fish</b></th>
                        <th style="text-align: center; width: 100px;"><b>Price <br>(per fish)</b></th>
                        <th style="text-align: center; width: 100px;"><b>Quantity</b></th>
                    </tr>


                    <?php
                    // Print out destination information in each row
                    foreach ($products as $productindex => $productarrayinfo) {
                        // Print out a fished in rows for the given product array info
                        printf('                    
                    <tr>
                        <td><img src="%s" width="150" height="100"></td>
                        <td><center>%s</center></td>
                        <td><center>$ %.2f</center></td>
                        <td><input type="text" name="number_of_fish[%d][order]" value=""></td>
                        
                    </tr>
                    ', $productarrayinfo['product'], 
                                $productarrayinfo['name'], 
                                $productarrayinfo['price'], 
                                $productindex, 
                                @quantity_errors_str($errors[$productindex]['order']) 
                                
                        );
                    }
                    ?>
                </tbody>
            </table>
            <br>
            <input name="send" id="send" type="submit" value="Order Now">
        </form>
    </center>
</body>
</html>
