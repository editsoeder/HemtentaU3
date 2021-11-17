<?php
include_once "../functions.php";

/* Gets an entry from specified file by given ID.
Returns the specific entry if found.
Returns NULL if no entry found.
*/
function getEntry($filename, $id){
    $data = getJSON($filename);
    $index = getIndexOfID($data, $id);
    return $data[$index];
}

/* Takes an integer and a data array.
Reduces amount of array entries down to given number.
Returns shortened array.
*/
function limitResult( $number, $data ){
    $sliced = array_slice($data, 0, $number );
    return $sliced;
}

/* 
Takes an array with data and returns highest ID.

*/

function getMaxID( $data ){
    if( count($data) < 1 ) {
        return 0;
    }
    $column = array_column($data, "id");
    $maxID = max($column);
    return $maxID;
}