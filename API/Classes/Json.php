<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Api;

/**
 * Description of JSON
 *
 * @author Shibin
 */
class Json {
    
    public function Json($obj) {
        // check if object is an error
        if (isset($obj['status']) && $obj['status'] == 'Error') {
            // serialize the error object as is
            $str = $obj;
        } else {
            // otherwise encode a success status into the object 
            $str = array(
                'status' => 'Success',
                'result' => $obj,
            );
        }
        // set json var to the serialized object
        return json_encode($str);
    }
    
    /*
     * Takes a JSON string and converts to an Object
     */
    protected function Parse($str) {
        return json_decode($str);
    }
    
}
