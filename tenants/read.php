<?php
require_once "../functions.php";

$directory = getDirectory();

if ( isMethod("GET") ) {
    $data = [];
    if( containsParam( "id" ) ){
        $id = $_GET["id"];
        $data = getEntry( "$directory.json", $id );
    }elseif( containsParam( "ids" ) ){
        $ids = explode(",", $_GET["ids"]);
        foreach( $ids as $id ){
            array_push( $data, getEntry( "$directory.json", $id ) );
        }
    }else{
        $data = getJSON("$directory.json");
    }

    $dataKeys = array_keys($data);

    

    foreach( $dataKeys as $key ){
        if( $key == "id" ){
            continue;
        }
        if( containsParam( $key ) ){
            $value = $_GET[$key];
            $data = filterBy($key, $value, $data );
        }
    }
    
    if( containsParam( "limit" ) ){
            $limit = $_GET["limit"];
            $data = limitResult($limit, $data);
    }

    sendJSON( [ $directory=>$data ] , 200);
} else{
    sendJSON(["message"=>"Method not allowed"], 400);
}