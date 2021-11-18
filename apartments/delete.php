<?php 
require_once("../functions.php");

$directory = getDirectory();

if (isMethod("DELETE")) { 
    if (isType("application/json")) {
        $entry = json_decode(file_get_contents("php://input"), true);
        
        if(is_null($entry) ){
            sendJSON(["message" => "Bad Request"], 400);
            exit();
        }

        if (!isset($entry["id"])) {
            sendJSON(["message" => "Missing ID"], 404);
        }
        
        deleteEntry("$directory.json", $entry["id"]);
        sendJSON(["message" => "Entry deleted", "Entry:" => $entry], 200);
        exit();
    
    } else { 
        sendJSON(["message" => "Wrong content-type"], 400);
    }

} else {
    sendJSON(["message" => "Method not allowed"], 405);
} 

?>
