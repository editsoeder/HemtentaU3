<?php 
require_once("../functions.php");

$directory = getDirectory();
$tenants = getJSON("../tenants/tenants.json");

if (isMethod("POST")) {
    if (isType("application/json")) {
        $entry = json_decode(file_get_contents("php://input"),true);

        if(is_null($entry) ){
            sendJSON(["message" => "Bad Request"], 400);
            exit();
        }

        $fields = [
            "address", 
            "landlord", 
            "tenants", 
            "rooms"
        ];
        
        if(checkAllFields($fields, $entry)) {
            sendJSON(["message" => "Missing key"], 400);
            exit();
        }

        if ( ! allFieldsSet($entry)) {
            sendJSON(["message" => "All fields must be filled in"], 400);
            exit();
        }

        $tenantsIDS = $entry["tenants"];
        foreach( $tenantsIDS as $tenantID ){
            if ( getIndexOfID( $tenants ,$tenantID ) == false ){
                sendJSON(["Message" => "The selected tenant does not exist"], 404);
            }
        }

        addEntry("$directory.json", $entry);
        sendJSON(["Message" => "Apartment created", "Apartment" => $entry], 200);
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
