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

    public function delete_document($index, $type, $id) {
        echo $this->endpoint , '/' . $index . '/' . $type . '/' . $id; die();
    }

    public function get_field_from_response($response, $field) {
        $decoded_reponse = json_decode($response);
        return $decoded_reponse->$field;
    }

    public function term_query_document_by_property($index, $type, $field, $value) {

        $body = '
        {
          "query": {
            "term": {
              "'.$field.'": "'.$value.'"
            }
          }
        }';

        return $this->curl->post($this->endpoint . '/' . $index . '/' . $type . '/_search', $body);
    }

}

?>