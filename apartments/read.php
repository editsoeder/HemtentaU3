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