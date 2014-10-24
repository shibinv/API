<?php
/*
 * @author: Navsquire Team Members
 */

require_once('Classes/Api.php');
require_once('Classes/Json.php');
require_once('Classes/Xml.php');
/*
 * Used to test API calls.
 * Will return debugging information
 */

// display all errors for testing
error_reporting(E_ALL);
ini_set('display_errors', 1);

// type of data to return (json | xml)
$type = filter_input(INPUT_GET, 'type');

// used to figure out what the request is for
$request = filter_input(INPUT_GET, 'request');

// value thats being passed in if needed
$value = filter_input(INPUT_GET, 'value');

// value thats being passed in if needed
$value2 = filter_input(INPUT_GET, 'value2');

// create API class
$api = new Api();

// set debug for testing
$api->setDebug(true);

// return json string back to client
$api->Find($request, $value, $value2);

// get the appropriate type of data
if ($type == 'xml') {
    // set the content type so document is displayed properly
    header('Content-Type: text/xml');
    $result = $api->getXml();  
} else {
    // content type not really needed
    header('Content-Type: application/json');
    $result = $api->getJson(); // default
}

echo $result; // send data back to client
