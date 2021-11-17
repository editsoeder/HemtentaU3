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

function deleteEntry($filename, $id) {
    //takes the filename which it should delete from
    //and ID which should be deleted
    $id = $requestData["id"];
    $data = getJSON($filename); 
    $found = getIndexOfID($data, $id);
    array_splice($data, $found, 1);
    saveToFile($filename, $data);
}

function sendJSON($message, $statuscode) {
    //is used whenever something is successful 
    // or goes wrong. exits the code

    header("Content-Type: application/json");
    http_response_code($statusCode);
    $jsonMessage = json_encode($message);

    echo($jsonMessage);
    exit();
}

function addEntry ($filename, $entry) {
    // $newEntry is an array with all the data that should be added to the array

    $userSentData = file_get_contents("php://input");
    $entry = json_decode($userSentData, true);
    // checkFields()

    if($filename == "apartments.json") {
        $newEntry = [
            $address = $entry["address"],
            $city = $entry["city"],
            $tenants = $entry["tenants"],
            $landlord = $entry["landlord"],
            $rooms = $entry["rooms"]
        ];
    }

    if($filename == "tenants.json") {
        $newEntry = [
            $id = getMaxID($data) + 1,
            $firstName = $entry["first_name"],
            $lastName = $entry["last_name"],
            $email = $entry["email"],
            $gender = $entry["gender"],
        ];
    }

    array_push($data, $newEntry);

    saveToFile($filename, $data);
}

