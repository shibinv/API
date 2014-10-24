<?php
/**
 * XML Class
 *
 * @author Navsquire Team Members
 */

//namespace Classes\Xml;

class Xml {

    private $xml;

    //put your code here
    public function Xml($obj) {
        
        // create a new xml and set root node
        $xml = new SimpleXMLElement('<response/>');
        
        // convert the array into xml
        $this->array_to_xml($obj, $xml);
        
        // set the global as xml string
        $this->xml = $xml->asXML();
    }

    public function getXml() {
        return $this->xml;
    }

    /*
     * method used to convert an array into xml
     * source: http://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml
     */
    private function array_to_xml($student_info, &$xml_student_info) {
        foreach ($student_info as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml_student_info->addChild("$key");
                    $this->array_to_xml($value, $subnode);
                } else {
                    $subnode = $xml_student_info->addChild("data");
                    $this->array_to_xml($value, $subnode);
                }
            } else {
                $xml_student_info->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

}
