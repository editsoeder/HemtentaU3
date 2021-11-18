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

function getDirectory(){
    return explode( "/", dirname($_SERVER['PHP_SELF']) )[1];
}

function containsParam( $param ){
    $keys = array_keys($_GET);
    return in_array($param, $keys);
}

function saveToFile ($filename, $data) {
    //Saves the changes to the database
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $json);
}

function isType ($type) {
    //returns true if the content to the server is the type we want
    return $type == $_SERVER["CONTENT_TYPE"];
}

function isMethod($method) {
    //returns true if the method sent to the 
    //server is the method we want/allow
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    return $method == $requestMethod;
}

function deleteEntry($filename, $id) {
    //takes the filename which it should delete 
    //from and ID which should be deleted
    $data = getJSON($filename); 
    $found = getIndexOfID($data, $id);
    array_splice($data, $found, 1);
    saveToFile($filename, $data);
}

function sendJSON($message, $statusCode) {
    //is used whenever something is successful 
    // or goes wrong. exits the code

    header("Content-Type: application/json");
    http_response_code($statusCode);
    $jsonMessage = json_encode($message);

    echo($jsonMessage);
    exit();
}

function addEntry ($filename, $entry) {
    //takes the data the user submitted and makes them into
    //a new entry in the database
    $data = getJSON($filename);
    $userSentData = file_get_contents("php://input");
    $entry = json_decode($userSentData, true);
    // checkFields()

    if($filename == "apartments.json") {
        $newEntry = [
            "id" => getMaxID($data) + 1,
            "address" => $entry["address"],
            "city" => $entry["city"],
            "tenants" => $entry["tenants"],
            "landlord" => $entry["landlord"],
            "rooms" => $entry["rooms"]
        ];
    }

    if($filename == "tenants.json") {
        $newEntry = [
            "id" => getMaxID($data) + 1,
            "first_name" => $entry["first_name"],
            "last_name" => $entry["last_name"],
            "email" => $entry["email"],
            "gender" => $entry["gender"],
        ];
    }

    array_push($data, $newEntry);

    saveToFile($filename, $data);
}


function editEntry ($filename, $entry) {
    $data = getJSON( $filename );
    $id = $entry["id"];
    $index = getIndexOfID($data, $id);
    $entryKeys = array_keys($entry);

    foreach( $entryKeys as $key ){
        $data[$index][$key] = $entry[$key];
    }
    
    saveToFile( $filename, $data);
}
  
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
If data arary is empty, returns 0.
*/
function getMaxID( $data ){
    if( count($data) < 1 ) {
        return 0;
    }
    $column = array_column($data, "id");
    $maxID = max($column);
    return $maxID;
}

/*
Takes a key and corresponding value (eg "rooms", 2) and data array.
Returns an array with data that has that value in that key.
*/
function filterBy( $key, $value, $data){
    $key = strtolower($key);
    $value = strtolower($value);
    $filtered = array_filter( $data, function($entry) use ($key, $value) {
            return $entry[$key] == $value;
        }
    );
    return $filtered;
}

/*
Takes the apartment array that should include tenants.
Finds each tenant and pushes it inside the apartments array.
Returns a new array with included tenants.
*/
function includeRelation( $apartments ){
    foreach( $apartments as $key=>$apartment ){
        $included = [];
        foreach( $apartment["tenants"] as $tenantID ){
            $tenant = getEntry( "../tenants/tenants.json", $tenantID );
            array_push($included, $tenant);
        }
        $apartments[$key]["tenants"] = $included;
    }
    return $apartments;
}

function checkAllFields($fields, $entry) {
    //Check if all the fields needed are submitted
    $entryKeys = array_keys($entry);
    $result = array_diff($fields, $entryKeys);

    return $result; 
}

function checkSomeFields( $fields, $entry ){
    $entryKeys = array_keys($entry);
    foreach( $entryKeys as $entryKey ){
        if( ! in_array($entryKey, $fields) ){
            return false;
        }
    }
    if( count($entryKeys) < 2 ){
        return false;
    }

    return true;
}


function allFieldsSet( $entry ) {
    foreach( $entry as $field ){
        if ( $field == "" ){
            return false;
        }
    }
    return true;
}
