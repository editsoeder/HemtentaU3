<?php
require_once "../functions.php";

if (isMethod("GET")) {
    $directory = getDirectory(); 
    $data = [];

    if (containsParam("id")) {
        $id = $_GET["id"];
        $data = getEntry("$directory.json", $id);

    } elseif (containsParam("ids")) {
        $ids = explode(",", $_GET["ids"]);

        foreach($ids as $id) {
            array_push($data, getEntry("$directory.json", $id));
        }
    } else {
        $data = getJSON("$directory.json");
    }

    if (containsParam("include")) {
        $data = includeRelation($data);
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

    if (containsParam("limit")) {
            $limit = $_GET["limit"];
            $data = limitResult($limit, $data); 
    }

    sendJSON ( [ $directory => $data ] , 200);

} else {
    sendJSON();
}