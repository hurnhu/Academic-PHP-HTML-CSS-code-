<?php

include "classInfo.php";


//this function will rest part and eq to normal values
function clearEverything()
{
    $_SESSION['part'] = 0;
    unset($_SESSION['eq']);
    unset($_SESSION['lastAns']);
}

//this function will process the EQ that was entered and preform the appropriate calculation
function processEq($x, $y, $operand)
{
    /*
     * check to see if either x or y are empty.
     * if it is, there is we are missing info to preform a calculation on
     */
    if (empty($x) || empty($y)) {

        //reset variables used for placement and EQ
        clearEverything();
        return "you must have 2 numbers to preform an operation on!";
    } else {

        //check to see if we are doing addition
    if ($operand == '+') {

        //apply calculation
        $result = $x + $y;
    } //check to see if we are doing subtraction
    else if ($operand == '-') {

        //apply calculation
        $result = $x - $y;
    } //check to see if we are doing multiplication
    else if ($operand == '*') {

        //apply calculation
        $result = $x * $y;
    } //check to see if we are doing division
    else if ($operand == '/') {

        //check for division by zero
        if ($y == 0) {

            //return error for division by zero
            $result = "Cannot Divide By Zero!";
        } else {

            //apply calculation
            $result = $x / $y;
        }
    } //check to see if we want teh remainder
    else if ($operand == '%') {

        //apply calculation
        $result = $x % $y;
    } else {

        //check to make sure they are only submitting operands that are supported
        $result = "please enter a valid operand!";
    }

        //reset session vars ued for pos and EQ
        clearEverything();
    }

    //return the answer
    return $result;
}