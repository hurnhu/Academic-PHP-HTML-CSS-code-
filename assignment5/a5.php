<?php
//start the session
session_start();

//make sure I include my file with the functions. by using require, i can ensure it is included
require_once "functions.php";
include "classInfo.php";

//session variable to show how many times you have tried to log in
$_SESSION['attempts'];

//start at 0 attempts
$_SESSION['attempts'] += 0;

//set the local currency type to united states
setlocale(LC_MONETARY, 'en_US');

//unset all variables associated with a user and logging in.
if ($_REQUEST['submit'] == 'logout') {
    unset($_SESSION['attempts']);
    unset($tempArr);
    unset($i);
}
?>

<!-- doctype and header were taken from one page php + html assignment in class -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
      xml:lang="en" lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta http-equiv="Content-Type"
          content="text/html; charset=utf-8"/>
    <title>ATM</title>
</head>

<body>

<!--
start my form, ensure anything entered into the textboxes not taken as code
this is done with htmlspecialchars, it converts any special chars to codes.
also refer to this page on submit.
-->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <?php

        //if they try and fail 3 times disallow them from trying again
        if ($_SESSION['attempts'] > 3) {

            //psudo ban their ip
            death();

        }

        /*
         * lambda/anonymous function. this function holds the code for the text boxes. this way i can use this code
         *in more than one place with out having to retype it. plus i though it would be fun to use an unnecessary lambda.
         * to learn how lambda work in php
         */

        $input = function () {

            ?>

            <input type="text" name="accountNum" placeholder="Account Number"></br>
            <input type="password" name="pw" placeholder="Password"></br>
            <button type="submit" name="submit" value="Submit">Submit</button>

            <?php

        };

        /*
         * check if the request method literally means POST and is the same type. the triple equals does not
         * cast either sides to check if they match. they have to mean the same thing and be the same type
         */
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_REQUEST['submit'] != 'logout') {

            //if the submit button has been pressed try to log in. this function returns true or false
            if (login($_REQUEST['accountNum'], $_REQUEST['pw'], $i)) {

                //if you successful log in, grab the users data and hold onto it.
                $tempArr = getInfo($i);

                /*
                 * this is an example of a closer statement in php. i allow it access to a variable outside of its scope
                 * instead of having to pass it in as an argument.
                 * this function just builds the string that is going to be displayed to the user.
                 */

                $fullName = function () use ($tempArr) {

                    return ($tempArr['fName'] . ' ' . $tempArr['lName']);

                };

                ?>

                <!-- show the user all of their info. all text boxes are disabled
                 this way the user can not muck with the data in them-->
                <p>user information:</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <a>Name: </a><br/>
                    <input type="text" value="<?php echo $fullName() ?>" disabled><br/>


                    <!-- display the balance as money. using the local currency type -->
                    <a>Balance: </a><br/>
                    <input type="text" value="<?php echo money_format('%i', $tempArr['bal']) ?>" disabled><br/>

                    <a>Account Open Date: </a><br/>
                    <input type="text" value="<?php echo $tempArr['accOD'] ?>" disabled><br/>
                    <button type="submit" name="submit" value="logout">Logout</button>
                </form>
                <?php

            } else {

                //if a user fails to log in, show a red error message and prompt again.
                echo '<p style="color: #ff2500">you entered in some bad data! </br> please try again</p> <p style="color: #ff2500">you are currently on attempt #';

                //ternary operator, shows the user a warning if they are on their last attempt
                echo ($_SESSION['attempts'] == '3') ? $_SESSION['attempts'] . ' </br> THIS IS YOUR FINAL ATTEMPT!' : $_SESSION['attempts'];
                echo '</p>';

                //show the texts boxes
                $input();

                //add one to the session variable.
                $_SESSION['attempts'] += 1;

            }

        } else {

            //show the user input text boxes
            $input();

        }
        ?>
</form>
</body>
