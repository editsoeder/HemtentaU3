<?php

function getJSON($filename){
    return json_decode(file_get_contents($filename), true);
}
