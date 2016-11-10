<?php
//*NOTE* TO TEST CHAR VALIDATION PUT NUMBERS IN STATE TEXT BOX. TO TEST NUMERIC VALIDATION PUT LETTERS IN QUANTITY TEXT BOX
//included file. this file is the comments showing what the purpose is of this program and variables
include 'classInfo.php';

//start the user session, this enables session variables to be persistent throughout page reloads.
session_start();

//declare both of my session variables i am using
$_SESSION['part'];
$_SESSION['userData'];
?>

<!-- i started with in class template provided for 1 page form-->
<!DOCTYPE html PUBLIC "-//W3C//DTDXHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
      xml:lang="en" lang="en">

<head>
    <title>Get Identity</title>
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1">
</head>


<body>

<?php

    /*
     * test if session is null or 0.
     * if it is, assign appropriate data to session. in this case the data is the product you want to buy
     * */

if ($_SESSION['part'] == null || $_SESSION['part'] == 0) {

        /*
         * userdata is an array of arrays. each element of the array is the information from each "page"
         * extraOptions is also an array.
         */
    $_SESSION['userData'][0] = array($_REQUEST['colors'], $_REQUEST['extraOptions'], $_REQUEST['quantity']);


    /*
     * check if the quantity field is numeric on form submit.
     * if it is not set part to 0, this way it stays on the first "page"
     * also set valid to false, this is use to show if the item in the quantity field was indeed a number (true) or false if it is not.
     */
    if (!is_numeric($_REQUEST['quantity'])) {
        $_SESSION['part'] = 0;
        $_SESSION['valid'] = false;

        /*
         * if the form has been submitted and the number is not numeric show an error message
         */
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //error message is red to show user it is a problem | bad practice to use inline CSS but is easiest.
            echo '<p style="color: red; font-weight:bold;">Quantity field is wrong, it needs to be a number!</p>';

        }

    } else {

        /*
         * if the number is numeric set valid to true
         */
        $_SESSION['valid'] = true;

        }

        /*
         * if valid is true then assign the value of submit to part.
         * the submit value is the buttons value, this value is used to show what "page" we should be on.
         * part is the actual page we are on.
         */

    if ($_SESSION['valid'] == true) {
        $_SESSION['part'] = $_REQUEST['submit'];

    }

} else if ($_SESSION['part'] == 1) {
        /*
         * test if session is 1.
         * if it is, assign appropriate data to session. in this case the data your shipping address
         * */
    $_SESSION['userData'][1] = array("streetAddress" => $_REQUEST['streetAddress'], "zip" => $_REQUEST['zip'], "state" => $_REQUEST['state'], "country" => $_REQUEST['country']);

    /*
     * test if the state is letters
     * if it is proceed onto the next "page" if it is not show error message and stay on this page
     */
    if (!ctype_alpha($_REQUEST['state'])) {
        /*
         * if state is not letters, stay on this page, and display error message
         */
        $_SESSION['part'] = 1;
        $_SESSION['valid'] = false;

        //error message is red to show user it is a problem | bad practice to use inline CSS but is easiest.
        echo '<p style="color: red; font-weight:bold;">state field is wrong, it needs to be a letter!</p>';

    } else {
        //the state is only letters set valid to true
        $_SESSION['valid'] = true;

    }

    /*
    * if valid is true then assign the value of submit to part.
    * the submit value is the buttons value, this value is used to show what "page" we should be on.
    * part is the actual page we are on.
    */

    if ($_SESSION['valid'] != false) {
        $_SESSION['part'] = $_REQUEST['submit'];

    }

} else if ($_SESSION['part'] == 2) {
        $_SESSION['valid'] = true;
    $_SESSION['userData'][2] = array("billingStreetAddress" => $_REQUEST['billingAddress'], "BillingZip" => $_REQUEST['billingZip'], "BillingState" => $_REQUEST['billingState'], "BillingCountry" => $_REQUEST['billingCountry']);

    /*
 * check if the zip field is numeric .
 * if it is not set part to 0, this way it stays on the third "page"
 * also set valid to false, this is use to show if the item in the zip field was indeed a number (true) or false if it is not.
 */

    if ($_REQUEST['same'] == 'ck') {

        /*
* check to see if the check box for "same as billing" is checked. if it is the billing address will be the same as the shipping address
*
*/
        $_SESSION['valid'] = true;

        //assign shipping address ['userData'][1] to billing address ['userData'][2]
        $_SESSION['userData'][2] = $_SESSION['userData'][1];

    } else if (!ctype_alpha($_REQUEST['billingState'])) {
        $_SESSION['part'] = 2;
        $_SESSION['valid'] = false;

        //error message is red to show user it is a problem | bad practice to use inline CSS but is easiest.
        echo '<p style="color: red; font-weight:bold;">state field is wrong, it needs to be a letter!</p>';
    }

    /*
     * if valid is true then assign the value of submit to part.
     * the submit value is the buttons value, this value is used to show what "page" we should be on.
     * part is the actual page we are on.
     */

    if ($_SESSION['valid'] != false) {
        $_SESSION['part'] = $_REQUEST['submit'];

    }

} else if ($_SESSION['part'] == 3) {
    /*
     * test if session part is 3.
     * if it is, assign appropriate data to session. in this case the results from your survey
     * */
    $_SESSION['userData'][3] = array($_REQUEST['service'], $_REQUEST['fav']);
        $_SESSION['part'] = $_REQUEST['submit'];

} else if ($_SESSION['part'] == 4) {
        /*
     * test if session part is 4.
     * if it is, assign appropriate data to session. in this case the data your shipping address
     * */
        $_SESSION['part'] = $_REQUEST['submit'];

    }


/*
 * each case in the switch statement is a new "page" with the default case being the first "page"
 * on button submit, and if info is valid, the "page" number is incremented to go to the next "page" in the switch
 */

switch ($_SESSION['part']) {
    case "1":
        ?>

        <!--this is the shipping address page-->
            <p>
                <b>shipping address</b>
            </p>

        <!--setting up the form. htmlspecialchars is used to help prevent XSS (cross site scripting) this way if someone put html, javascript, or php code
        in one of the text boxes it will not execute it. it does this by converting special characters to to values EX < will turn into &lt;.
        $_SERVER["PHP_SELF"] is used to redirect this page to itself.
        http://php.net/manual/en/function.htmlspecialchars.php
        http://stackoverflow.com/questions/19584189/when-used-correctly-is-htmlspecialchars-sufficient-for-protection-against-all-x
        -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <p>
                <!-- text boxes to gather information for your shipping address.
                php code inside of value will make this a "sticky form" if error check returns you to this page with supplied error
                 all info submitted should still be in the correct place. this avoids having the user enter everything in again.-->
                Address:
                <input type="text" name="streetAddress" value="<?php if (isset($_REQUEST['streetAddress'])) {
                    echo $_POST['streetAddress'];
                } ?>">

                ZIP:
                <input type="text" name="zip" value="<?php if (isset($_REQUEST['zip'])) {
                    echo $_POST['zip'];
                } ?>">

                <!-- state has a max length of 2, i want the abbreviation of the state-->
                State:
                <input type="text" name="state" maxlength="2" size="2" value="<?php if (isset($_REQUEST['state'])) {
                    echo $_POST['state'];
                } ?>">

                Country:
                <input type="text" name="country" value="<?php if (isset($_REQUEST['country'])) {
                    echo $_POST['country'];
                } ?>">

            <p>
                <!--navigation buttons to go to next page or previous page.-->
                <button type="submit" name="submit" value="0">Previous Page</button>
                <button type="submit" name="submit" value="2">Next Page</button>
            </p>

            </p>

        </form>
        <?php
        break;
    case "2":
        ?>
        <!--this is the billing address page-->

            <p>
                <b>billing address</b>
            </p>
        <!--setting up the form. htmlspecialchars is used to help prevent XSS (cross site scripting) this way if someone put html, javascript, or php code
in one of the text boxes it will not execute it. it does this by converting special characters to to values EX < will turn into &lt;.
$_SERVER["PHP_SELF"] is used to redirect this page to itself.
http://php.net/manual/en/function.htmlspecialchars.php
http://stackoverflow.com/questions/19584189/when-used-correctly-is-htmlspecialchars-sufficient-for-protection-against-all-x
-->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <p>
                <!-- php code inside of value will make this a "sticky form" if error check returns you to this page with supplied error
 all info submitted should still be in the correct place. this avoids having the user enter everything in again.-->
                Same as shipping?
                <input type="checkbox" name="same" value="ck">

                Address:
                <input type="text" name="billingAddress" value="<?php if (isset($_REQUEST['billingAddress'])) {
                    echo $_POST['billingAddress'];
                } ?>">

                ZIP:
                <input type="text" name="billingZip" value="<?php if (isset($_REQUEST['billingZip'])) {
                    echo $_POST['billingZip'];
                } ?>">

                State:
                <input type="text" name="billingState" maxlength="2" size="2"
                       value="<?php if (isset($_REQUEST['billingState'])) {
                           echo $_POST['billingState'];
                       } ?>">

                Country:
                <input type="text" name="billingCountry" value="<?php if (isset($_REQUEST['billingCountry'])) {
                    echo $_POST['billingCountry'];
                } ?>">

            <p>
                <!--navigation buttons to go to next page or previous page.-->
                <button type="submit" name="submit" value="1">Previous Page</button>
                <button type="submit" name="submit" value="3">Next page</button>
            </p>
            </p>
        </form>
        <?php
        break;
    case "3":
        ?>
        <!--this is the user survey page-->
            <p>
                <b>survey</b>
            </p>

        <!--setting up the form. htmlspecialchars is used to help prevent XSS (cross site scripting) this way if someone put html, javascript, or php code
in one of the text boxes it will not execute it. it does this by converting special characters to to values EX < will turn into &lt;.
$_SERVER["PHP_SELF"] is used to redirect this page to itself.
http://php.net/manual/en/function.htmlspecialchars.php
http://stackoverflow.com/questions/19584189/when-used-correctly-is-htmlspecialchars-sufficient-for-protection-against-all-x
-->
        <form id="survey" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <p>
                how would you rate our service?
                <br/>
                <?php

                /*
                 * generate 10 radio buttons 0-10 for the customer to rate our service
                 * in the for loop it will display a radio button with its number and same value.
                 * on submit the value of the selected radio button will be submitted
                 */

                for ($i = 0; $i != 10; $i++) {
                    echo $i . " " . '<input type="radio" name="service" value=' . $i . '>';
                }

                ?>

                <br/>
                please pick your favorite number in this list!
                <br/>

                <?php

                //variables used in while loop
                $bool = true;
                $randNum;
                $b = 0;

                /*
                 * the while loop will exit if bool is false.
                 *
                 * the while loop is similar to the for loop in the case that it generates radio buttons with a value.
                 * but differs in the way of how it does it.
                 * the while loop will generate a minimum of 2 radio buttons and if the random number is able to be divided
                 * by 2 with no remainder. if this creiteria is meet break out of the while by setting $bool to true
                 *
                 * a random number is generated by the following formula.
                 * randomNum(between -995 and 245) * randomNum(between -10 and 9875) / randomNum(between -112 and 10000)
                 * this entire number is rounded.
                 */

                while ($bool) {
                    $b++;
                    $randNum = round(rand(-995, 245) * rand(-10, 9875) / rand(-112, 10000));
                    echo $randNum . " " . '<input type="radio" name="fav" value=' . $randNum . '>';

                    if ($randNum % 2 != 0) {
                        if ($b > 2) {
                            $bool = false;
                        }

                        }

                    }

                ?>
            <p>
                <!--navigation buttons to go to next page or previous page.-->
                <button type="submit" name="submit" value="2">Previous page</button>
                <button type="submit" name="submit" value="4">Next Page</button>

            </p>
            </p>
        </form>
        <?php
        break;
    case "4":

        /*
        *since the session variable userdata is an array of arrays (if aly of the check boxes on the first page are checked
        *their will be a third array inside of the array.)
        *
        *each for each loop will iterate over the array and print out the key name and the value associated to that key.
        *each are indented by a tab
        *
        *walking this one full set of the foreach would go. the first array in userdata will be used in the second foreach
        *each item inside of that array will be iterated over. there their is also an array in that array iterate over it.
        */

        foreach ($_SESSION['userData'] as $key => $value) {
            echo $key . "=" . $value . "<br>";

            foreach ($value as $key1 => $value1) {
                echo "<pre>   " . $key1 . "=" . $value1 . "</pre>";

                foreach ($value1 as $key2 => $value2) {
                    echo "<pre>       " . $key2 . "=" . $value2 . "</pre>";

                }

                }

            }

        ?>

        <!-- small form to advance to the page with great formatting -->
        <form id="survey" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit" name="submit" value="5">view all vars with optimal formatting</button>
        </form>
        <?php

        break;
    case "5":

        //i got the code to display everything in session variable from here http://stackoverflow.com/questions/3331613/how-to-print-all-sessions-currently-set-in-php
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';

        break;
    default:
        ?>

            <p>
                <b>What color would you like to buy?</b>
            </p>

        <!--setting up the form. htmlspecialchars is used to help prevent XSS (cross site scripting) this way if someone put html, javascript, or php code
in one of the text boxes it will not execute it. it does this by converting special characters to to values EX < will turn into &lt;.
$_SERVER["PHP_SELF"] is used to redirect this page to itself.
http://php.net/manual/en/function.htmlspecialchars.php
http://stackoverflow.com/questions/19584189/when-used-correctly-is-htmlspecialchars-sufficient-for-protection-against-all-x
-->
        <form id="main" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <img style="width: 100px; height: 100px;" src="media/colors.jpg"/>

            <!-- drop down lise for witch color you would like to buy -->
            <p>color:

                <select name="colors">

                    <optgroup label="Available Colors">
                        <option value="red">red</option>
                        <option value="yellow">yellow</option>
                        <option value="blue">blue</option>

                    </optgroup>

                </select>
            </p>

            <!-- check boxes to see if the user would like any of the extra options applied to their order. -->
            <p>
                free gift box?
                <input type="checkbox" name="extraOptions[]" value="fgb">

                extra packing materials?
                <input type="checkbox" name="extraOptions[]" value="epm">

            </p>

            <!-- text box for what qty they would like -->
            <p>Quantity:

                <input type="text" name="quantity" value="<?php if (isset($_REQUEST['billingCountry'])) {
                    echo $_POST['zip'];
                } ?>">
            </p>

            <p>
                <button type="submit" name="submit" value="1">Next page</button>
            </p>
        </form>
        <?php
}
?>


</body>
<footer>

</footer>
