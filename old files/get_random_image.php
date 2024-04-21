<?php

// Make a GET request to the API endpoint
$response = file_get_contents('https://api.example.com/photos/random');

// Check if the request was successful
if ($response !== false) {
    // Decode the JSON response
    $data = json_decode($response, true);

    // Check if the JSON decoding was successful
    if ($data !== null) {
        // Get the URL of the random image
        $imageUrl = $data['url'];

        // Send the image URL back to JavaScript
        echo json_encode(['imageUrl' => $imageUrl]);
    } else {
        // JSON decoding failed
        echo json_encode(['error' => 'Failed to decode API response']);
    }
} else {
    // Request failed
    echo json_encode(['error' => 'Failed to make API request']);
}
