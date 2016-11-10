<?php
/*
Author: Michael LaPan
Professor: Hira Herrington
Course: ISYS-288-001-Fall 2016
Purpose: Assignment 5 - this is an ATM program, it allows a user to log into their bank account
see their balance, account open date, and the first name and last name.
after they see their info they can logout

I/O: N/A
Interfaces:

function login($aNum, $pw, &$x) -  log in function.
 this function accepts the users id and password. and passed by reference the position of the user in the arrays
 this function loops through the arrays looking for their  account number and password matches what is in the
 corresponding arrays.
 if it is found it will return true, else false

Variables:
$aNum - account number to check in the arrays

$pw - password to find in the arrays. pw must be in the corresponding parallel array to account num

&$x - pos of the persons information in the array. this is passed by reference


function getInfo($i) - this function returns an an array with all of the users information.
what ever number is passed in, it will return the corresponding spot in the parallel arrays

Variables:

$i - pos in array for get and return the information


death() - bans the users ip, if they fail to log in to many times

Variables:

$deny - array with ip address to deny access to the site.


Variables:

$_SESSION['attempts']; - is the current attempt the user is on for logging in.

$input - holds the results for the lambda function. in this case it holds all of the
text boxes

$tempArr - this will hold all of the information for the user.
this is an array that is populated by the getInfo method
this is an associative array

$i - this is the users pos in the parallel arrays.

$fullName - holds the results of the php closure statement.
this is just a concatenation of their first name and last name.

*/

