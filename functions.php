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

function saveToFile ($filename, $data) {
    //Saves the changes to the database
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}

function isType ($type) {
    //returns true if the content to the server is the type we want
    return $type == $_SERVER["CONTENT-TYPE"];
}

function isMethod($method) {
    //returns true if the method sent to the server is the method
    //we want/allow
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    return $method == $requestMethod;
}