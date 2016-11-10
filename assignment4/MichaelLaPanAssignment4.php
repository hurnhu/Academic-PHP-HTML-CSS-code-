<?php
/*
 * include file that holds the operations to preform on the numbers.
 * refer to functions.php for in-depth detail
*/
include "classInfo.php";
require_once "functions.php";

//start my session and reserve my session variables
session_start();
$_SESSION['eq'];
$_SESSION['part'];


//check if the last button pushed was the = sign and make sure the form was submitted
if (($_REQUEST['submit'] == '=' || $_REQUEST['submit'] == 'CE') && $_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_REQUEST['submit'] == 'CE') {
        //reset session variables part and EQ
        clearEverything();

    } else {

        //send operand, and bother numbers to be processed
        $solved = processEq($_SESSION['eq'][0], $_SESSION['eq'][2], $_SESSION['eq'][1]);

        //save the last answer so if the user would like to preform an operation on it they can
        $_SESSION['lastAns'] = $solved;

    }

} elseif ($_REQUEST['submit'] == '--' && $_SERVER['REQUEST_METHOD'] == 'POST') {

    //if the minus button is pressed, it will enter this if to make the number negative

    /*
     * if there is no number entered and there is an answer in last ans.
     * take the last answer and make it negative
     */
    if (empty($_SESSION['eq'][0]) && !empty($_SESSION['lastAns'])) {

        //times the number by -1 to make it negative
            $_SESSION['eq'][0] = $_SESSION['lastAns'] * -1;


    } else {
        /*
         * if their is nothing in last answer, we know they want a negative number.
         * if we are at the first part, that means we want to make the first number negative
         */

        if ($_SESSION['part'] == 0) {

            /*
             * check to see if there is anything entered yet. if there is nothing entered, append a negative sign in there
             * if there is something entered times it by negative one to make it negative.
             */
            if (empty($_SESSION['eq'][0])) {

                $_SESSION['eq'][0] .= '-';

            } else {

                $_SESSION['eq'][0] *= -1;

            }


        } elseif ($_SESSION['part'] == 2) {

            /*
 * check to see if there is anything entered yet. if there is nothing entered, append a negative sign in there
 * if there is something entered times it by negative one to make it negative.
 */
            if (empty($_SESSION['eq'][2])) {

                $_SESSION['eq'][2] .= '-';

            } else {

                $_SESSION['eq'][2] *= -1;

            }
        }

    }

} else {

    //if what was submitted is not a number continue and make sure it was post.
    if (!is_numeric($_REQUEST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

        /*
         * check to see if the first number is empty.
         * if it is that means they would like to preform an the last answer
        */

        if (empty($_SESSION['eq'][0])) {

            //since they would like to preform an operation on the last answer. assign last answer to the first number
            $_SESSION['eq'][0] = $_SESSION['lastAns'];

            //increment the part
            $_SESSION['part'] += 1;

            //this would be the operation they want to preform on the last answer
            $_SESSION['eq'][$_SESSION['part']] = $_REQUEST['submit'];

            //increment part so the next number entered is after the operand
            $_SESSION['part'] += 1;
        } else {

            $_SESSION['part'] += 1;

            //assign operand to the appropriate part (should be position 1)
            $_SESSION['eq'][$_SESSION['part']] = $_REQUEST['submit'];

            $_SESSION['part'] += 1;
        }

    } else {
        /*
         * assign number to preform an action on to the appropriate part.
         * by concatenation it allows the user to enter a number that is more than 1 digit long.
         */

        $_SESSION['eq'][$_SESSION['part'] + 0] .= $_REQUEST['submit'];
    }
}
?>

<!-- doctype and header were taken from one page php + html assignment in class -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta http-equiv="Content-Type"
          content="text/html; charset=utf-8"/>
    <title>Calculator</title>
</head>

<body>

<!-- set up the form. htmlspecialchars is used to help prevent php code injections. page refers to itself for what page to post to -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div>

            <button type="submit" name="submit" value="--">(-)</button>

        <!-- if a problem has been solved, show the answer to the user in the text field.
         the text field is also locked so the user can not edit the or input anything.
          this helps avoid bad user input.-->
        <input type="text" name="textfield" value="<?php if (isset($solved) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            echo $solved;
        } else {

            //if the user did not previously try to calculate anything show what they have imputed
            echo $_SESSION['eq'][0] . ' ' . $_SESSION['eq'][1] . ' ' . $_SESSION['eq'][2];
        } ?>" disabled <?php if (strpos($solved, '!')) {

            //if $solved contains an !, that means their was an error so turn it RED so the user knows it was an error.
            echo 'style="color: red"';
        }
        ?>>

            <button type="submit" name="submit" value="CE">CE</button>
        </div>

        <!--button sets are set up in divs, each div is a new row in the column (refer to style.css for explanation)-->
        <div>
            <button type="submit" name="submit" value="1">1</button>
            <button type="submit" name="submit" value="2">2</button>
            <button type="submit" name="submit" value="3">3</button>
            <button type="submit" name="submit" value="-">-</button>
        </div>

        <div>
            <button type="submit" name="submit" value="4">4</button>
            <button type="submit" name="submit" value="5">5</button>
            <button type="submit" name="submit" value="6">6</button>
            <button type="submit" name="submit" value="/">/</button>
        </div>

        <div>
            <button type="submit" name="submit" value="7">7</button>
            <button type="submit" name="submit" value="8">8</button>
            <button type="submit" name="submit" value="9">9</button>
            <button type="submit" name="submit" value="*">*</button>
        </div>

        <div>
            <button type="submit" name="submit" value="0">0</button>
            <button type="submit" name="submit" value="%">MOD</button>
            <button type="submit" name="submit" value="+">+</button>
            <button type="submit" name="submit" value="=">=</button>
        </div>
    </form>
</body>
