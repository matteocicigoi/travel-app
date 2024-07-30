<?php 
//Check if a file exists
function checkFile($fileName){
    if(!file_exists(__DIR__ . '/' . $fileName)){
        file_put_contents(__DIR__ . '/' . $fileName, '{}');
    }else{
        $file = file_get_contents(__DIR__ . '/' . $fileName);
        if(empty($file)){
            file_put_contents(__DIR__ . '/' . $fileName, '{}');
        }
    }
}
//Returns and decodes the JSON content in the file
function getFile($fileName){
    checkFile($fileName);
    return json_decode(file_get_contents(__DIR__ . '/' . $fileName));
}
//Save the file
function saveFile($fileName, $json){
    checkFile($fileName);
    file_put_contents(__DIR__ . '/' . $fileName, json_encode($json));
}
//Generate a string composed of 10 characters
function getRandomString(){
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $result = '';
    for($i = 0; $i < 15; $i++){
        if(rand(0,1) === 0){
            //Number
            $result .= rand(0, 9);
        }else{
            //Character
            $char = $characters[rand(0, (strlen($characters) - 1))];
            if(rand(0,1) === 0){
                //Uppercase
                $result .= strtoupper($char);
            }else{
                $result .= $char;
            }
        }

    }
    return $result;
}
?>