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
    
    // the return string that will be sent back to the client
    private $return;
    
    // type of data to return (json or xml)
    private $type = 'json';
    
    /*
     * Class Constructor
     */
    public function Api($type = 'json') {
        //change to xml if set
        if ($type == 'xml') {
            $this->type = 'xml';
        }
        
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
            $result = $this->Error($ex->getMessage());
            $str = new Json($result);
            echo $str;
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
    
    /*
     * Returns errors back to client
     */
    protected function Error($msg) {
        
        // check what type to errors to return
        if ($this->debug == true) {
            // return error status and message
            $error = array(
                'status' => 'Error', 
                'message' =>$msg,
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
    public function Find($request, $value) {
        
        // 
        if ($request == 'department') {
            $this->Dept();
        } elseif ($request == 'course') {
            $this->Course($value);
        } elseif ($request == 'section') {
            $this->Section($value);
        } else { // return an error is request is not valid
            $this->return = $this->Error('Unknown Request');
        }
        
        return $this->return;
    }
    
    protected function Query($sql) {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            $result = $this->Error($ex->getMessage());
        }
        // return as a json string
        //var_dump($result);
        if ($this->type == 'json') {
            $this->return = New Json($result);
        }
    }
}
