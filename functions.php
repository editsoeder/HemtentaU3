<?php

// Opens json file and decodes it.
// Returns an associative array.
function getJSON($filename){
    return json_decode(file_get_contents($filename), true);
}

/* 
Searches array for ID.
Returns index if found
Returns false if no ID found.
OBS! Index 0 is NOT false
*/
function getIndexOfID($data, $id){
    $column = array_column($data, "id");
    $index = array_search($id, $column);
    return $index;
}
