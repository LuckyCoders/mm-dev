<?php
/*
 * Soap Lib TrinityCore2
 *
 * © 2010 - MiniManager
 */

class TCSoap {
    private $client = NULL;

    public function __construct($conArr) {
        $this->connect($conArr['soap_user'], $conArr['soap_pass'], $conArr['addr'], $conArr['soap_port']);
    }

    public function connect($soapUser, $soapPass, $soapHost, $soapPort) {
        $this->client = new SoapClient(NULL, array(
                                        "location" => "http://".$soapHost.":".$soapPort."/", //http://ip:port/
                                        "uri" => "urn:TC", //trinity namespace
                                        "user_agent" => "MiniManager 1.0",
                                        "style" => SOAP_RPC,
                                        "login" => $soapUser,
                                        "password" => $soapPass,
                                        "trace" => 1, //enable usage of some soap functions
                                        "exceptions" => 0
                                        ));
        
        if(is_soap_fault($this->client))
        {   
            $client = $this->client;
            throw new Exception("SOAP Error | Faultcode: ".$client->faultcode." | Faultstring: ".$client->faultstring);
            return false;
        }
        return true;
    }

    // Destroy SOAPClient
    public function disconnect() {
        if ($this->client != NULL)
            $this->client = NULL;
        else
            return false;
        
        return true;
    }

    /*
     * Send command to TC server
     *
     * @param: (string) command
     * @return: (string) xmlresult
     */
    public function fetch($command) {
        $client = $this->client;
        
        if ($client == NULL)
            return false;


        $params = func_get_args();
        array_shift($params); //remove first param

        $command = vsprintf($command, $params);
        
        $result = $client->executeCommand(new SoapParam($command, "command"));

        if(is_soap_fault($client))
        {
            throw new Exception("SOAP Error | Faultcode: ".$client->faultcode." | Faultstring: ".$client->faultstring);
            return false;
        }

        return $this->getResult($client->__getLastResponse());
    }
    
    private function getResult($xmlresponse) {
        $start = strpos($xmlresponse,'<?xml');
        $end = strrpos($xmlresponse,'>');
        $soapdata = substr($xmlresponse,$start,$end-$start+1);
      
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $soapdata, $vals, $index);
        xml_parser_free($xml_parser);
        
        if (array_key_exists("RESULT",$index))
            $result = $vals[$index['RESULT'][0]]['value'];
        
        if (!empty($result))
            return $result;
            
        return ""; //no output
    }
}
?>