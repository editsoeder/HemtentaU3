<?php 
require_once("../functions.php");

$directory = getDirectory();

if (isMethod("POST")) {
    if (isType("application/json")) {
        $entry = json_decode(file_get_contents("php://input"), true);

        $fields = [
            "address", 
            "landlord", 
            "tenants", 
            "rooms"
        ];

        if(checkAllFields($fields, $entry)) {
            sendJSON(["message" => "Missing fields"], 400);
        }

        if ( ! allFieldsSet($entry)) {
            sendJSON(["message" => "All fields must be filled in"], 400);
        }
        addEntry("$directory.json", $entry);
        sendJSON([$directory => $entry], 200) ;
    } else {
        sendJSON(["message" => "Wrong content-type"], 400);
    }
} else {
    sendJSON(["message" => "Wrong method"], 405);
}

?>
