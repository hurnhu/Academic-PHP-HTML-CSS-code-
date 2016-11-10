<?php
include "classInfo.php";

//start the session.
session_start();

//all the arrays containing the users data. this should be stored in a database for security reasons.
//these are all session because it is easier than having these all as global vars.
$_SESSION['accNum'] = [111221, 111222, 111223, 111224, 111225, 111226, 111227, 111228, 111229, 111230];
$_SESSION['fName'] = ['Patty', 'George', 'Jean', 'Frank', 'Steve', 'Alex', 'Judy', 'Joe', 'Francis', 'Ray'];
$_SESSION['lName'] = ['Smith', 'Franklin', 'Cherrybaum', 'Goldman', 'Templeton', 'Bedat', 'Tiems', 'Chang', 'Mulee', 'Ucalme'];
$_SESSION['pw'] = [5478, 7302, 3811, 4092, 2722, 6120, 3610, 2341, 3124, 5432];
$_SESSION['accOD'] = ['1976-10-11', '1986-10-12', '1976-08-13', '1996-01-14', '1998-01-01', '2000-01-01', '2000-01-01', '2016-03-16', '1989-01-01', '1994-01-01'];
$_SESSION['bal'] = [36984, 5324, 3500, 350, 15478, 117412, 325, 35684, 5123, 45369];


/**
 *log in function.
 * this function accepts the users id and password. and passed by reference the position of the user in the arrays
 * this function loops through the arrays looking for their  account number and password matches what is in the
 * corresponding arrays.
 *
 * if it is found it will return true, else false
 */
function login($aNum, $pw, &$x)
{
    for ($i = 0; $i < sizeof($_SESSION['accNum']); $i++) {

        if ($aNum == $_SESSION['accNum'][$i] && $pw == $_SESSION['pw'][$i]) {
            $x = $i;
            return true;
        }
    }
    return false;
}

/**
 *this function returns an array for the user. this user is shown as their position in the array.
 */
function getInfo($i)
{
    return array('accNum' => $_SESSION['accNum'][$i], 'fName' => $_SESSION['fName'][$i], 'lName' => $_SESSION['lName'][$i], 'pw' => $_SESSION['pw'][$i], 'accOD' => $_SESSION['accOD'][$i], 'bal' => $_SESSION['bal'][$i]);
}

/**
 * my favorite function.
 * this function is only called if you failed to login more than 3 times.
 * this function gets your IP address and compares it to a list of ip addresses it should ban.
 * if it is found, then it will navigate you to the denied paged (psudo 503 page).
 * code was taken from https://perishablepress.com/how-to-block-ip-addresses-with-php/
 * made slight modifications.
 */
function death()
{
    $deny = array($_SERVER['REMOTE_ADDR']);
    if (in_array($_SERVER['REMOTE_ADDR'], $deny)) {
        header("location: deny.html");
        exit();
    }
}