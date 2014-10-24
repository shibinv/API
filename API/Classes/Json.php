<?php
/**
 * JSON Class
 * 
 * @author Navsquire Team Members
 */

//namespace Classes\Json;

class Json {
    
    private $json;
    
    public function Json($obj) {
        // set json var to the serialized object
        $this->json = json_encode($obj);
    }
    
    /*
     * Set json back to driver
     */
    public function getJson() {
        return $this->json;
    }
    /*
     * Takes a JSON string and converts to an Object
     */
    protected function Parse($str) {
        return json_decode($str);
    }
    
}
