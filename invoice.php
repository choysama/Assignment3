<html>
    <head>
        <meta charset="UTF-8">
        <title>I'a (Fish) Market</title>
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>
        
<?php

Require("products.php");
/*#SECURITYHOLE
 * Issue: Using GET instead of POST
 */
$quantities = $_GET['quantity'];
/*#SECURITYHOLE
 * Issue: Using GET instead of POST
 */
if (!empty($quantities) && !empty($_GET['username'])) {

?>


    
    <!-- #SECURITYHOLE -->  
    <center><h1><?php print "Welcome " . $_GET['username'] . "!"; ?></h1>
        <p>Please review your invoice for the order you've placed.</p>

        <table style= border-collapse:collapse border=4>
            <tbody>
                <tr>
                    <th style="text-align: center; width: 100px;"><b>Fish</b></th>
                    <th style="text-align: center; width: 100px;"><b>Quantity</b></th>
                    <th style="text-align: center; width: 100px;"><b>Price <br> (per fish)</b></th>
                    <th style="text-align: center; width: 100px;"><b>Extended Price</b></th>                     
                </tr>

                <?php
                // Print out all the fishes & their information in each row
                $subtotal = 0;
                $items_ordered = 0;
                foreach ($products as $productindex => $productarrayinfo) {
                    // Print out a fishes row for the given product array info

                    $number_of_fish = @$quantities[$productindex]['order'];

                    if ($number_of_fish == 0)
                        continue;
                    $items_ordered += $number_of_fish;
                    $extendedprice = $productarrayinfo['price'] * @$quantities[$productindex]['order'];
                    $subtotal += $extendedprice;

                    // Create extended price strings for orders
                    $all_qty_str = '<td style="text-align: center">none</td>';
                    if (@$quantities[$productindex]['order'] > 0) {
                        $all_qty_str = sprintf('<td style="text-align: center;"><b>%d</td>'
                                , @$quantities[$productindex]['order']);
                    }                  

                    printf('                    
                    <tr>
                        <td style="text-align: center; width: 100px;"><b>%s</td>'
                            . $all_qty_str
                            . '<td style="text-align: center; width: 100px;">$ %.2f</td>'
                            . '<td style="text-align: center; width: 100px;">$ %.2f</td>
     
                    </tr>
                    ', $productarrayinfo['name'], $productarrayinfo['price'], $extendedprice
                    );
                }

                // Calculate and print tax; Paula's Asst 1
                $tax_rate = 0.0575;
                $tax = $subtotal * $tax_rate;

                // Calculate and print delivery fee based on subtotal
                if ($subtotal >= 100) {
                    $delivery_fee = $subtotal * 0.07;
                } elseif ($subtotal <= 49.99) {
                    $delivery_fee = 0;
                } elseif ($subtotal <= 99.99) {
                    $delivery_fee = 3;
                }

                // Compute final total 
                $total = $subtotal + $tax + $delivery_fee;
                ?>

<!--print calculation (bottom) portion of invoice-->
                <tr>
                    <td colspan = "3" width = "50%%" style='text-align: right; '>
                        Sub-total
                    </td>
                    <td style = "text-align: center;" width = "30%%">
                        $<?php printf('%.2f', $subtotal); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan = "3" width = "50%%" style='text-align: right; '>
                        Tax @ 5.75%
                    </td> 
                    <td style = "text-align: center;" width = "30%%">
                        &nbsp;
                        $<?php printf('%.2f', $tax); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan = "3" width = "50%%" style='text-align: right; '>
                        Delivery Fee
                    </td>
                    <td style = "text-align: center;" width = "30%%">
                        $<?php printf('%.2f', $delivery_fee); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan = "3" width = "50%%" style='text-align: right; '>
                        <b>Total</b>
                    </td> 
                    <td style = "text-align: center;" width = "30%%">
                        <b>
                            $<?php printf('%.2f', $total); ?>
                        </b>
                    </td>
                </tr>

            </tbody>

        </table>
        <br>
<!--        <form action = '<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']; ?>' method= 'post'>
            <INPUT TYPE="SUBMIT" name='confirm' value='Confirm Order'>
        </form>-->
        <br>



    </center>
</body>
</html> 
<?php
//end of if-statements testing empty fields
}
?>
