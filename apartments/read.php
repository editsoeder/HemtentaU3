<?php
include_once "../functions.php";

function containsParam( $param ){
    $dbKeys = array_keys(getJSON("apartments.json")[0]);

    

    var_dump(stripos("rooms", $param));

    if( $param == 'ids' ){

    }
    if( $param == 'include' ){

    }
    if( $param == 'limit' ){

    }
}

containsParam( "rooms" );