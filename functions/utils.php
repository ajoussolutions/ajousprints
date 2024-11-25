<?php

/**
 * Check if node is installed (Windows and Linux)
 */
function isNodeInstalled() {
    return file_exists('/usr/bin/node') || file_exists('C:\Program Files\nodejs\node.exe');
}

function preparePrint($data,$template){
//check if template exists
if(!file_exists('templates/'.$template.'.html')){
    throw new Exception("Template not found: $template");
}
//generate token
$token = bin2hex(random_bytes(16));

//replace {{data}} with $data as json
$html = str_replace('{{data}}', json_encode($data), file_get_contents('templates/'.$template.'.html'));

//save to temp folder
file_put_contents('temp/'.$token.'.html', $html);

return $token;
}





