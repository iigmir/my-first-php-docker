<?php

header("Content-Type: application/json ; charset=utf-8");

$data = array(
    "message" => "Hello World!",
    "param" => null,
    "data" => array()
);

echo( json_encode($data) );
