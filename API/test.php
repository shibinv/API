<?php
require_once('classes/API.php');
/*
 * Used to test API calls.
 * Will return debugging information
 */


// used to figure out what the request is for
$request = $_GET['request'];
// value thats being passed in if needed
$value = $_GET['value'];

// check if request is null
if ($request == '') {
    $result = array(
        'status' => 'Error',
        'message' => 'Bad Call',
    );
    // send error back to client
    echo json_encode($result); 
    // end the process
    die;
}


// create API class
$api = new API();
// set debug for testing
$api->debug = true;
// return json string back to client
echo $api->find($request, $value);




