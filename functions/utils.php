<?php


function preparePrint($data,$template){

    //remove all files older than 1 minute in temp folder
    $files = glob(DOL_DOCUMENT_ROOT.'/custom/ajousprints/temp/*');
    foreach($files as $file){
        if(is_file($file) && !is_dir($file) && filemtime($file) < time() - 60){
            unlink($file);
        }
    }
    $templatepath = DOL_DOCUMENT_ROOT.'/custom/ajousprints/templates/'.$template.'.html';
//check if template exists
if(!file_exists($templatepath)){
    throw new Exception("Template not found: ".$templatepath);
}
//generate token
$token = bin2hex(random_bytes(16));

$templateheader = file_get_contents(DOL_DOCUMENT_ROOT.'/custom/ajousprints/templates/base/header.html');
$templatefooter = file_get_contents(DOL_DOCUMENT_ROOT.'/custom/ajousprints/templates/base/footer.html');
$templatecode = file_get_contents($templatepath);


//replace {{data}} with $data as json
$html = str_replace('{data}', json_encode($data), $templateheader.$templatecode.$templatefooter);

//save to temp folder
file_put_contents(DOL_DOCUMENT_ROOT.'/custom/ajousprints/temp/'.$token.'.html', $html);

return $token;
}

//get pdf from gotenberg


function savePdf($data,$template,$path,$params=array()){
    //dolibarr config
    global $conf;
    $gotenberg_url = $conf->global->AJOUSPRINTS_GOTENBERG_URL;
    $temp_html_url = $conf->global->AJOUSPRINTS_TEMP_HTML_URL;

   $token = preparePrint($data,$template);
   //prepare post request
   $url = $gotenberg_url.'/forms/chromium/convert/url';
   $post = array('url'=>$temp_html_url.'/'.$token.'.html');
   //merge params with post
   $post = array_merge($post,$params);
   //execute post request
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $response = curl_exec($ch);
   curl_close($ch);
   
   //check if response is ok and code is 200
   if($response === false || curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200){
    throw new Exception("Error getting PDF: ".curl_error($ch)." - ".$url." - ".json_encode($post));
   }
   try{
   //if folder doead not exist, create it
   if(!file_exists(dirname($path))){
    mkdir(dirname($path), 0777, true);
   }
    file_put_contents($path, $response);
   }catch(Exception $e){
    throw new Exception("Error saving PDF: ".$e->getMessage());
   }
   //delete temp html
   unlink(DOL_DOCUMENT_ROOT.'/custom/ajousprints/temp/'.$token.'.html');
   return 1;
}


