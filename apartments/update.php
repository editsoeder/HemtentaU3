<?php 
require_once("../functions.php");

$directory = getDirectory();

if (isMethod("PATCH")) {
    if (isType("application/json")) {
        $entry = json_decode(file_get_contents("php://input"), true);

        $fields = [
            "id",
            "address", 
            "landlord", 
            "tenants", 
            "rooms"
        ];

        if (!isset($entry["id"])) {
            sendJSON(["message" => "Missing ID"], 400);
            exit();
        }

        if(!checkSomeFields($fields, $entry)) {
            sendJSON(["message" => "Missing fields"], 400);
            exit();
        }

        if ( ! allFieldsSet($entry)) {
            sendJSON(["message" => "The fields must be filled in"], 400);
            exit();
        }

        editEntry("$directory.json", $entry);
        sendJSON([$directory => $entry], 200);
        exit();

    } else {
        sendJSON(["message" => "Wrong content-type"], 400);
        exit();
    }
} else {
    sendJSON(["message" => "Wrong method"], 405);
    exit();
}

?>
