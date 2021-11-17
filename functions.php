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

//idk if this one is done but maybe
function saveToFile ($filename, $data) {
    //Saves the changes to the database
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}

function isType ($type) {
    //check content type of what someone sends the server
    //so that its in fact content type json
    //if not, sendJSON with message "Wrong format, please
    //use JSON
    $jsonFormat = header("Content-type: application/json");
    if ($type !== $jsonFormat) {
        sendJSON(
            [
                "message" => "Content type not allowed, please send data in JSON"
            ], 
            400);
    }
}

function isMethod($method) {
    //checks that the method sent by the server is the same as
    //the method sent by the server
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    return $method == $requestMethod;
}