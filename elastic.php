<?php

require_once 'curl/curl.php';

class elastic{

    public $curl;
    public $endpoint;

    function __construct($endpoint, $port) {
        $this->endpoint = $endpoint . ':' .$port;
        $this->curl = new Curl;
    }

    public function add_index($index) {
        return $this->curl->put($this->endpoint . '/' . $index . '/');
    }

    public function add_mapping($index, $type, $mapping) {
        return $this->curl->put($this->endpoint . '/' . $index . '/_mapping/' . $type, $mapping);
    }

    public function add_document($index, $type, $document) {
        return $this->curl->post($this->endpoint . '/' . $index . '/' . $type . '/', $document);
    }

}

?>