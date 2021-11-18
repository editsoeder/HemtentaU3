<?php

require_once "../functions.php";

$directory = getDirectory();

if( isMethod("DELETE") ){
    if( isType("application/json") ){
        $entry = json_decode(file_get_contents("php://input"),true);
        var_dump($entry);

        if ( ! isset($entry["id"]) ){
            sendJSON(["message"=>"ID MISSING"],400);
        }
        deleteEntry("$directory.json", $entry["id"]);
        exit();
    }else{
        sendJSON(["message"=>"Wrong content-type"], 400);
        exit();
    }
}else{
    sendJSON(["message"=>"Wrong Method"], 405);
    exit();
}
