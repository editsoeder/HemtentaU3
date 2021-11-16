<?php
include_once "../functions.php";

/*
Takes an integer and a data array.
Reduces amount of array entries down to given number.
Returns shortened array.
*/
function limitResult( $number, $data ){
    $sliced = array_slice($data, 0, $number );
    return $sliced;
}