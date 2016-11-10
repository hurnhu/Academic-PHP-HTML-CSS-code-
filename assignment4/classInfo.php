<?php
/*
Author: Michael LaPan
Professor: Hira Herrington
Course: ISYS-288-001-Fall 2016
Purpose: Assignment 4 - this is a calculator! you can add, subtract, make negative, multiply, divide, modulus, clear everything and does basic error
checking like division by zero, make sure it is valid numbers, or no operator selected.
the text box that holds the equation is locked so users are unable to enter their own input. they must use the buttons.
This is to reduce user input error, by limiting them to only options I provide.

I/O: N/A
Interfaces:

clearEverything() - void function that resets specific session variables and variables.

processEq($x, $y, $operand) -
this function takes 3 arguments:
$x - this is the first number the user enters.
$y - this is the second number that the user enters.
$operand - this is the calculation they want to preform on the 2 numbers EX add/divide.

with these 3 arguments it figures out what calculation it should preform on the numbers.
error checking is also built into the function. if any errors are found it will return
the corresponding error.

Variables:

$_SESSION['eq'] - this session variable will hold the entire equation for parsing.
$_SESSION['part'] - this holds the current part that you are on. this will dictate where the number will go if you enter one
$_SESSION['lastAns'] - this hold the last answer from the last equation you entered in. this answer may be used for
further computation
$solved - this is a temp variable to hold the last answer.


************************Possible Bug**************************
 * Because I have been using same session variable 'part' between my assignments. There is the possibilities that
 * that the part session variable will have something in it. If you were previously on my of my assignments.
**************************************************************
*/

