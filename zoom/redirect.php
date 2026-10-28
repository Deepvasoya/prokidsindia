<?php

$code = $_REQUEST['code'];
$recurect = "https://app.lmh-ai.in/zoom/redirect.php";
$appid = "lrRu0LL7QHmfexhMXH1rsQ";
$secretKey = "Rnm7N82KSA0PdwxNQBDO9kLFkZgNi7qc";
$base64 = base64_encode($appid.":".$secretKey);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://zoom.us/oauth/token?grant_type=authorization_code&code=".$code."&redirect_uri=".$recurect,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic $base64"
  ),
));

$response = curl_exec($curl);

curl_close($curl);

try{
    
    
    if(isset(json_decode($response)->error)){
        print_r($response);
        die;
    }
    
     $token = json_decode($response)->access_token;
     
    
     $senddata = array("agenda" => "Meeting",
     "default_password" => false,
     "duration" => 60,
     "password" => "123456",
     "type" => 2
     );


        $url="https://api.zoom.us/v2/users/me/meetings";
        $header = array("Authorization: Bearer $token","Content-Type: application/json");
        $curl = curl_init();
	    curl_setopt_array($curl, array(
		    CURLOPT_URL => $url,
		    CURLOPT_HTTPHEADER => $header,
		    CURLOPT_SSL_VERIFYPEER => true,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => json_encode($senddata)
	    ));
        $meetingresponse = curl_exec($curl);

       
        curl_close($curl);
        
        
         if(isset(json_decode($meetingresponse)->start_url)){
               $startURL =  json_decode($meetingresponse)->start_url;
               
               echo "<script type=\"text/javascript\">
                window.open('".$startURL."', '_blank')
            </script>";
            
    
               
          }else{
              echo "Something went wrong!!";
          }
    
        

}catch(Exception $e){
    echo "Unable to create token";
    
}

   
    


?>