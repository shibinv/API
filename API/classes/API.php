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
    // set true when testing
    public $debug = false; 
    
    // JSON string used for return
    public $json;
    
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
        $user = 'hawkie';
        $pass = 'hawkie';
        try {
            // connect to the database
            $this->db = new PDO('mysql:host=localhost;dbname=hawknest;charset=utf8', $user, $pass);
            // throw exceptions
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        } catch(PDOException $ex) {
            $result = $this->Error($ex);
            $this->json = $this->SerializeJSON($result);
            echo $this->json;
            die; // stop further processing 
        }
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
     * Takes an object and converts to a JSON String
     */
    protected function SerializeJSON($obj) {
        // check if object is an error
        if (isset($obj['status']) && $obj['status'] == 'Error') {
            // serialize the error object
            $str = $obj;
        } else {
            // otherwise encode a success status into the object 
            $str = array(
                'status' => 'Success',
                'result' => $obj,
            );
        }
        // return the serialized object
        return json_encode($str);
    }
    
    /*
     * Takes a JSON string and converts to an Object
     */
    protected function ParseJSON($str) {
        return $obj;
    }
    
    /*
     * Returns errors back to client
     */
    protected function Error($ex) {
        
        // check what type to errors to return
        if ($this->debug == true) {
            // return error status and message
            $error = array(
                'status' => 'Error', 
                'message' =>$ex->getMessage(),
            );
        } else {
            // return only an error status
            $error = array('status' => 'Error');
        }
        
        return $error;
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
     * Converts the requests to database calls and 
     * sets results to $json variable
     */
    public function find($request, $value) {
        
        // 
        if ($request == 'deparment') {
            $this->json = $this->Dept();
        }
        
        if ($request == 'course') {
            $this->json = $this->Course($value);
        }
        
        if ($request == 'section') {
            $this->json = $this->Section($value);
        }
        
        return $this->json;
    }
    
    protected function Query($sql) {
        try {
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            $result = $this->Error($ex);
        }
        // return as a json string
        return $this->SerializeJSON($result);
    }
}
