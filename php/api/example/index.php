<?php

header("Content-Type: application/json ; charset=utf-8");

function get_website()
{
    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, "https://example.com"); // URL to request
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting it
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification (for example purposes)

    // Execute the cURL session and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if(curl_errno($ch)) {
        http_response_code(502);
        return 'cURL Error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Process and use the $response
    return $response;
}

$data = array(
    "message" => "API from example.com",
    "param" => null,
    "data" => get_website()
);

echo( json_encode($data) );
