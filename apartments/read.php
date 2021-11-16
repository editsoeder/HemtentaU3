<?php
include_once "../functions.php";

/*
Gets an entry from specified file by given ID.
Returns the specific entry if found.
Returns NULL if no entry found.
*/
function getEntry($filename, $id){
    $data = getJSON($filename);
    $index = getIndexOfID($data, $id);
    return $data[$index];
}