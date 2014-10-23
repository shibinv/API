<?php
require_once('classes/API.php');
/*
 * Used to test API calls.
 * Will return debugging information
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

// used to figure out what the request is for
$request = filter_input(INPUT_GET, 'request');

// value thats being passed in if needed
$value = filter_input(INPUT_GET, 'value');

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
$result = $api->find($request, $value);
echo $result;
var_dump($result);
