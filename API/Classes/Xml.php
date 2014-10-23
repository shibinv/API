<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//namespace Classes\Xml;

/**
 * Description of Xml
 *
 * @author Shibin
 */
class Xml {
    
    private $xml;
    //put your code here
    public function Xml($obj) {
        $this->xml = 
                '<hello><test>testing xml</test></hello>';
    }
    
    public function getXml() {
        return $this->xml;
    }
}
