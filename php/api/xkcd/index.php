<?php

header("Content-Type: application/json ; charset=utf-8");

function get_param($requestUri)
{
    $segments = explode("/", $requestUri);
    $lastSegment = end($segments);
    if (is_numeric($lastSegment)) {
        return $lastSegment;
    } else {
        return null;
    }
}

function get_message()
{
    $param = get_param($_SERVER["REQUEST_URI"]);
    if ($param == "404") {
        return "404: not found";
    } else if (is_numeric($param) ) {
        return "success";
    } else if( $param == null ) {
        return "success";
    } else {
        return "Input is invalid";
    }
}

function get_data()
{
    function get_api($id)
    {
        if( $id == null ) {
            return "https://xkcd.com/info.0.json";
        }
        return "https://xkcd.com/" . $id . "/info.0.json";
    }
    function get_website($param)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, get_api($param) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        if(curl_errno($ch)) {
            http_response_code(502);
            return 'cURL Error: ' . curl_error($ch);
        }
        curl_close($ch);

        if( json_decode($response) == null ) {
            http_response_code(400);
            return "Request error: API:" . get_api($param);
        }
        return json_decode($response);
    }
    $param = get_param($_SERVER['REQUEST_URI']);
    if( $param == "404" ) {
        http_response_code(404);
        return null;
    }
    return get_website( $param );
}

$data = array(
    "message" => get_message(),
    "param" => get_param($_SERVER['REQUEST_URI']),
    "data" => get_data()
);

echo( json_encode($data) );
