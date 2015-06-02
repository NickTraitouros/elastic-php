<?php

require_once "curl/lib/curl.php";

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

    public function delete_index($index){
        return $this->curl->delete($this->endpoint . '/' . $index .'/');
    }

    public function add_mapping($index, $type, $mapping) {
        return $this->curl->put($this->endpoint . '/' . $index . '/_mapping/' . $type, $mapping);
    }

    public function delete_mapping($index, $type) {
        return $this->curl->delete($this->endpoint . '/' . $index . '/_mapping/' . $type);
    }

    public function get_mapping($index, $type) {
        return $this->curl->get($this->endpoint . '/' . $index . '/' . '_mapping' . '/' . $type);
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

    public function bool_query($index, $type, $must=array(), $must_not=array(), $should=array()) {

        $must_expression = "";

        if ($must){
            foreach($must as $field=>$value) {
                $must_expression .= '{"match" : { "'.$field.'" : "'.$value.'" }},';
            }
            $must_expression = substr($must_expression, 0, -1);
        }

        $must_not_expression = "";

        if ($must_not){

            foreach($must_not as $field=>$value) {
                $must_not_expression .= '{"match" : { "'.$field.'" : "'.$value.'" }},';
            }

            $must_not_expression = substr($must_not_expression, 0, -1);
        }

        $should_expression = "";

        if ($should){
            foreach($should as $field=>$value) {
                $should_expression .= '{"match" : { "'.$field.'" : "'.$value.'" }},';
            }

            $should_expression = substr($should_expression, 0, -1);
        }

        $body = '
        {
            "query": {
                "bool": {
                    "must" : ['.$must_expression.'],
                    "must_not" : ['.$must_not_expression.'],
                    "should" : ['.$should_expression.']
                    }
                }
        }';

        return $this->curl->post($this->endpoint . '/' . $index . '/' . $type . '/_search', $body);
    }

    public function match_query($index, $type, $field, $value, $operator = "or") {

        $body = '
        {
            "query":{
                "match" : {
                    "'.$field.'" : {
                    "query" : "'.$value.'",
                    "operator" : "'.$operator.'"
                    }
                }
             }
        }
        ';

        return $this->curl->post($this->endpoint . '/' . $index . '/' . $type . '/_search', $body);

    }

    public function multi_match_query($index, $type, $fields, $value) {
        $body = '
        {
            "query": {
              "multi_match" : {
                "query":      "' . $value . '",
                "type":       "best_fields",
                "fields":     [ "' . implode('","',$fields) . '" ]
              }
            }
        }';
    }
}

?>