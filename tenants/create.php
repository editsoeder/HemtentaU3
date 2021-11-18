<?php

require_once "../functions.php";

$directory = getDirectory();

if( isMethod("POST") ){
    if( isType("application/json") ){
        $entry = json_decode(file_get_contents("php://input"),true);
        $fields = [
            "first_name", 
            "last_name", 
            "gender", 
            "email"
        ];

        if (  checkAllFields($fields, $entry) ) {

            sendJSON(["message"=>"Missing key"], 400);
            exit();
        }
        if( ! allFieldsSet($entry) ){
            sendJSON(["message"=>"All fields must be filled in"], 400);
            exit();
        }
        addEntry("$directory.json", $entry);
        sendJSON( [ $directory=>$entry ] , 200);
        exit();

    }else{
        sendJSON(["message"=>"Wrong content-type"], 400);
        exit();
    }
}else{
    sendJSON(["message"=>"Wrong Method"], 405);
    exit();
}
