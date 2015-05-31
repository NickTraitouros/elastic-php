<?php

require_once 'elastic.php';

$elastic = new elastic('http://ec2-52-5-71-197.compute-1.amazonaws.com','9200');

 echo $elastic->add_index('mammals');
 echo $elastic->delete_index('mammals');

// $mapping = '
// {
//     "properties" : {
//         "size" : {"type" : "string", "store" : true, "index": "not_analyzed"},
//         "color" : {"type" : "string", "store" : true, "index": "not_analyzed"},
//         "species" : {"type" : "string", "store" : true}
//     }
// }

// ';

// echo $elastic->add_mapping('insects','bees',$mapping);

// echo $elastic->get_mapping('insects', 'bees');

// $document = '
// {
//    "size"    : "big",
//    "color"   : "yellow and black",
//    "species" : "bumblebee"
// }';

// echo $elastic->add_document('insects', 'bees', $document);
