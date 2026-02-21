<?php
function mostrarURL(){
    //$host= $_SERVER["HTTP_HOST"];
    $url= $_SERVER["REQUEST_URI"];
    echo "http://" . $host . $url;
}

function crearJSON(){
    //API URL
    $url = $_SERVER["REQUEST_URI"];

    //create a new cURL resource
    $ch = curl_init($url);

    //setup request to send json via POST
    $user = array(
        'id' => '123',
        'name' => 'juan'
    );
    $payload = json_encode($user);
    echo $payload;
    //attach encoded JSON string to the POST fields
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    //set the content type to application/json
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    //return response instead of outputting
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
   // $result = curl_exec($ch);

    //close cURL resource
    //curl_close($ch);
}

    
crearJSON();
?>