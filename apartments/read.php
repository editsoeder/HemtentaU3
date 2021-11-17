<?php
include_once "../functions.php";

$directory = getDirectory();

function getDirectory(){
    return explode( "/", dirname($_SERVER['PHP_SELF']) )[1];
}

function containsParam( $param ){
    $keys = array_keys($_GET);
    return in_array($param, $keys);
}
