<?php

/**
 * API Class
 * procceses requests and returns JSON
 *
 * @author Navsquire Team Members
 */
namespace Api;

class Api {
    
    //database object
    private $db;
    // set true when testing
    private $debug = false; 
    
    // this holds the results from the database
    private $data;
    
    // holds the error information
    private $error;
    
    /*
     * Class Constructor
     */
    public function Api() {
        
        // connect to the Database
        $this->ConnectDB();
    }
    
    /*
     * Establish connection to the database
     */
    protected function ConnectDB() {
        $user = 'hawkie';
        $pass = 'hawkie';
        try {
            // connect to the database
            $this->db = new PDO('mysql:host=localhost;dbname=hawknest;charset=utf8', $user, $pass);
            // set PDO to throw exceptions
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $ex) {
            $this->Error($ex->getMessage());
        }
    }
    
    /*
     * Converts the requests to database calls and 
     * Results are set to $this->data variable
     */
    public function Find($request, $value) {
        
        // check if an error already occured
        if ($this->error) {
            return; // stop further processing
        }
        
        // make the call according to the request
        if ($request == 'department') {
            $this->Dept();
        } elseif ($request == 'course') {
            $this->Course($value);
        } elseif ($request == 'section') {
            $this->Section($value);
        } else { // set error if request is invalid
            $this->Error('Unknown Request');
        }
    }
    
    /* 
     * returns an array of departments
     * Ex: result[0] = array('dept_id' => '1', 'dept_subject' => 'CINF'); 
     */
    protected function Dept(){
        $sql = "SELECT dept_id, dept_subject FROM department";
        $this->Query($sql);
    }
    
    /*
     * Returns an object of the room's location from the database 
     * based on input string
     */
    protected function Room($str) {
        $sql = "SELECT room_xval, room_yval FROM room WHERE room_id = $str";
        return $obj;
    }
    
    /* **** needs further work *****
     * Returns an object of various tables from the database 
     * based on input string
     */
    protected function Search($str) {
        //$sql = "SELECT room_number,  FROM full_course WHERE dept_subject = '$str'";
        //$this->Query($sql);
    }
    
    /*
     * Returns an object of Courses from the database 
     * based on input string 
     */
    protected function Course($str) {
        $sql = "SELECT course_number FROM full_course WHERE dept_subject = '$str'";
        $this->Query($sql);
    }
    
    /*
     * Returns an object of Sections from the database 
     * based on input string
     */
    protected function Section($str) {
        //$stmt = $this->db->query('SELECT * FROM course WHERE course')
    }
    
    /*
     * Returns errors back to client
     */
    protected function Error($msg) {
        
        // check what type to errors to return
        if ($this->debug == true) {
            // return error status and message
            $error = array(
                'status' => 'Error', 
                'message' => $msg,
            );
        } else {
            // return only an error status
            $error = array('status' => 'Error');
        }
        
        $this->error = $error;
    }
    
    protected function Query($sql) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // set $data to result
            $this->data = $result;
        } catch (PDOException $ex) {
            $this->Error($ex->getMessage());
        } 
    }
    
    /* 
     * Call this to get Json
     * converts data into json and returns it
     */
    public function getJson() {
        if ($this->error){
            $json = new Json($this->error);
        } else {
            $json = new Json($this->data);
        }
        return $json; // needs error checking ***** here or in json class
    }
    
    /*
     * Call this to get Xml
     */
    public function getXml() {
        if ($this->error) {
            $xml = new Xml($this->error);
        } else {
            $xml = new Xml($this->data);
        }
        
        return $xml;
    }
}
