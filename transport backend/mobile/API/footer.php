<?php

echo json_encode(array(

    "success" => $success,

    "version" => $version_code,

    "tag" => $tag,

    "return_id" => $return_id,

    "msg" => $msg,

    "data" => $data,
    
    "data1" => $data1,
     "status"=>$status,
    "response" => isset($response) ? $response : null,

));

?>
