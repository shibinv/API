<?php

/**
 * API Class
 * procceses requests and returns JSON
 *
 * @author Shibin
 */
class API {
    
    //database object
    private $db;
    //Comment by the amazing Quentin McMullen
    
    /*
     * Class Constructor
     */
    public function API() {
        // connect to the Database
        $this->ConnectDB();
        // to do
    }
    
    /*
     * Establish connection to the database
     */
    protected function ConnectDB() {
        //$this->db = new PDO();
    }
    
    /*
     * Returns an object of Rooms from the database 
     * based on input string
     */
    protected function Room() {
        return $obj;
    }
    
    /* **** needs further work *****
     * Returns an object of various tables from the database 
     * based on input string
     */
    protected function Search($str) {
        return $obj;
    }
    
    /*
     * Returns an object of Courses from the database 
     * based on input string 
     */
    protected function Course($str) {
        return $obj;
    }
    
    /*
     * Returns an object of Sections from the database 
     * based on input string
     */
    protected function Section($str) {
        return $obj;
    }
    
    /*
     * Takes an object and converts to a JSON String
     */
    protected function SerializeJSON($obj) {
        return $str;
    }
    
    /*
     * Takes a JSON string and converts to an Object
     */
    protected function ParseJSON($str) {
        return $json;
    }
    
    /*
     * Returns errors back to client
     */
    protected function Error($str) {
        return $str;
    }
}
