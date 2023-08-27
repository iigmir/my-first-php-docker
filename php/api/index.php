<?php

header("Content-Type: application/json ; charset=utf-8");

$data = array(
    "message" => "Hello World!"
);

echo( json_encode($data) );
