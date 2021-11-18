<?php 
require_once("../functions.php");

$directory = getDirectory();

if (isMethod("DELETE")) { 
    if (isType("application/json")) {
        $entry = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($entry["id"])) {
            sendJSON(["message" => "Missing ID"], 400);
        }
        
        deleteEntry("$directory.json", $entry["id"]);
    
    } else { 
        sendJSON(["message" => "Wrong content type"], 400);
    }

} else {
    sendJSON(["message" => "Wrong method"], 405);
} 

?>
