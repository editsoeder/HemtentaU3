<?php

require_once "../functions.php";

$directory = getDirectory();

if( isMethod("PATCH") ){
    if( isType("application/json") ){
        $entry = json_decode(file_get_contents("php://input"),true);
        $fields = [
            "first_name", 
            "last_name", 
            "gender", 
            "email"
        ];

        if ( ! isset($entry["id"]) ){
            sendJSON(["message"=>"ID MISSING"],400);
            exit();
        }
        if( ! checkSomeFields( $fields, $entry ) ){
            sendJSON(["message"=>"Missing field"], 400);
            exit();
        }
        if( ! allFieldsSet($entry) ){
            sendJSON(["message"=>"All fields must be filled in"], 400);
            exit();
        }
        editEntry("$directory.json", $entry["id"]);
        exit();
    }else{
        sendJSON(["message"=>"Wrong content-type"], 400);
        exit();
    }
}else{
    sendJSON(["message"=>"Wrong Method"], 405);
    exit();
}

