<?php

/**
 * API Class
 * procceses requests and returns JSON
 *
 * @author Navsquire Team Members
 */
//namespace Classes\Api;

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
            $this->Error('Could not connect to DB: '.$ex->getMessage());
        }
    }
    
    /*
     * Converts the requests to database calls; default is department 
     * Results are set to $this->data variable
     */
    public function Find($request = 'department', $value = null, $value2 = null) {
        
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
            $this->Section($value, $value2);
        } elseif ($request == 'room') {
            $this->Room($value);
        } else { // set error if request is invalid
            $this->Error('Unknown Request');
        }
    }
    
    /* 
     * returns an array of departments
     * Ex: result[0] = array('dept_id' => '1', 'dept_subject' => 'CINF'); 
     */
    protected function Dept(){
        $sql = "SELECT dept_id, dept_subject FROM department ORDER BY dept_subject";
        $this->Query($sql);
    }
    
    /*
     * Returns an object of the room's location from the database 
     * based on input string
     */
    protected function Room($class) {
        if ($class == '') {
            $this->Error('Room Request must contain value={roomnumber}');
        } else {
            $sql = "SELECT room_xval, room_yval, room_number FROM full_course WHERE class_number = '$class'";
            $this->Query($sql);
        }
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
     * filters if an input string is provided
     */
    protected function Course($str) {
        $sql = "SELECT course_number FROM full_course";
        if ($str != '') {
            $sql .= " WHERE dept_subject = '$str'";
        }
        $sql .= " ORDER BY course_number"; // sort them so its easier to read
        $this->Query($sql);
    }
    
    /*
     * Returns an object of Sections from the database 
     * based on input string
     */
    protected function Section($department, $course) {
        if ($department == '' || $course == '') {
            $this->Error('Section Request must contain value={department}, and value2={coursenumber}');
        } else {
            $sql = "SELECT course_section, class_number FROM full_course WHERE dept_subject ='$department'"
                    . " AND course_number = '$course' ORDER BY course_section";
            $this->Query($sql);
        }
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
            $this->Error('Database Query Error: '.$ex->getMessage());
        } 
    }
    
    /* 
     * Call this to get Json
     * converts data into json and returns it
     */
    public function getJson() {
        $json = new Json($this->BuildData()); // figure out if error or valid data
        return $json->getJson(); // send to class  to build  // needs error checking ***** here or in json class
    }
    
    /*
     * Call this to get Xml
     */
    public function getXml() { 
        $xml = new Xml($this->BuildData()); // figure out if error or valid data
        return $xml->getXml(); // send to class  to build 
    }
    
    /*
     * determine if there is an error and send back error
     * otherwise send data
     */
    private function BuildData() {
        if ($this->error) {
            return $this->error;
        } else {
            $data = array( // append a success element into the array
                'status' => 'success',
                'result' => $this->data
                );
            return $data;
        }
    }
    
    public function setDebug($status = false) {
        if ($status == true) {
            $this->debug = true;
        }
    }
}
