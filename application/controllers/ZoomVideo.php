<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'/third_party/googleclient/vendor/autoload.php'; 


class ZoomVideo extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        
                 /*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);*/
 
         $timezoneDB = $this->db_model->select_data('timezone','site_details',array('id'=>1));
        if(isset($timezoneDB[0]['timezone']) && !empty($timezoneDB[0]['timezone'])){
            date_default_timezone_set($timezoneDB[0]['timezone']);
        }
        
    }
    
    function letSend(){
        $token = "dRsLinkBSq-zoCRLIHjWrf:APA91bFcSao9UBMGBUS7xEkkML_uDsT2AQS7FyIXV4wUaldL_t2OC_Nk5hJjwYbJd4OCyvkHi0AxQMs-iO5iXGYN_XdCyHH_U1poh6KQz3Ou5uLY2ctnY8WjoZq8TMBZoYnAYI2ZYIbW"; //FCM Device token
        $title = "Test from PHP";
        $body = "This is a test from PHP";
        $data = ['key' => 'value'];

        //$this->sendFCMNotification($token, $title, $body, $data);
        $token = "varsha testing";
        $this->sendNotificationFromTopic($token, $title, $body);
    }
    
    
     
    function sendNotificationFromTopic($topic, $title, $body) {
        //echo $topic;
        //echo "===";
        $accessToken = $this->getOATHToken();
        $payload = ["message" => ["topic" => $topic, "notification"=>["title" => $title, "body"=> $body], "data"=>["title" => $title, "body"=> $body]]];
        //echo json_encode( $payload );
    
        
            $headers = array
            (
            'Authorization: Bearer '.$accessToken,
            'Content-Type: application/json'
            );
            #Send Reponse To FireBase Server    
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/lmh-ai/messages:send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $payload ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            
        
        //$result = file_get_contents('https://fcm.googleapis.com/v1/projects/lmh-ai/messages:send', false, $context);
    
         //echo "\n\n======RESPONSE======\n\n";
         //echo $result;
        return true;
    
    }
    
    
    
    
    function getOATHToken(){
    $client = new Google_Client();
    try {
        $client->setAuthConfig(APPPATH.'/firebase/service.json');
        $client->addScope(Google_Service_FirebaseCloudMessaging::CLOUD_PLATFORM);

        $savedTokenJson = $this->readSavedToken();

        if ($savedTokenJson) {
            // the token exists, set it to the client and check if it's still valid
            $client->setAccessToken($savedTokenJson);  
            $accessToken = $savedTokenJson;
            if ($client->isAccessTokenExpired()) {
                // the token is expired, generate a new token and set it to the client
                $accessToken = $this->generateToken($client);
                $client->setAccessToken($accessToken);
            }
        } else {
            // the token doesn't exist, generate a new token and set it to the client
            $accessToken = generateToken($client);
            $client->setAccessToken($accessToken);
        }
        

        $oauthToken = $accessToken["access_token"];

        return $oauthToken;

        
    } catch (Google_Exception $e) {}
   return false;
}

    //Using a simple file to cache and read the toke, can store it in a databse also
    function readSavedToken() {
      $tk = @file_get_contents('token.cache');
      if ($tk) return json_decode($tk, true); else return false;
    }
    
    function writeToken($tk) {
     file_put_contents("token.cache",$tk);
    }

    function generateToken($client)
    {
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken();
    
        $tokenJson = json_encode($accessToken);
        $this->writeToken($tokenJson);
    
        return $accessToken;
    }


    // Finally
    function sendNotification($token, $title, $body) {
    
    $accessToken = $this->getOATHToken();
        $payload = ["message" => ["token" => $token, "notification"=>["title" => $title, "body"=> $body], "data"=>["title" => $title, "body"=> $body]]];
    
        
            $headers = array
            (
            'Authorization: Bearer '.$accessToken,
            'Content-Type: application/json'
            );
            #Send Reponse To FireBase Server    
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/lmh-ai/messages:send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $payload ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            
            
        
    


    
        //$result = file_get_contents('https://fcm.googleapis.com/v1/projects/lmh-ai/messages:send', false, $context);
    
        echo "\n\n======RESPONSE======\n\n";
        echo $result;
    
    }
    
    function createAccessToken(){
	    
	    $code = $_REQUEST['code'];
		$idAndLiveClassId = explode("-",$_REQUEST['id']);
		$id = $idAndLiveClassId[0];
		$liveClassId = $idAndLiveClassId[1];
		
		
		$baseurl = base_url();
        $recurect = $baseurl.'ZoomVideo/createAccessToken?id='.$id.'-'.$liveClassId;
        
	    $livedata =$this->db_model->select_data('*','live_class_setting',array('id' =>$liveClassId));
	    $appid = $livedata[0]['zoom_api_key'];
    	$secretKey = $livedata[0]['zoom_api_secret'];
    	$base64 = base64_encode($appid.":".$secretKey);



	
//$url =  "https://zoom.us/oauth/token?grant_type=authorization_code&code=".$code."&redirect_uri=".$recurect;

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
        echo "Error in aouth token api";
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
               $joinURL  =  json_decode($meetingresponse)->join_url;
               
               // Update Join Url into our database for joining student
               $data_arr=array('join_url'=>$joinURL);
		       $this->db_model->update_data_limit('live_class_history',$data_arr,array('id'=>$id),1);
		
               
               echo "<script type=\"text/javascript\">
                window.open('".$startURL."', '_blank')
            </script>";
          }else{
              echo "Something went wrong!!";
          }
      }catch(Exception $e){
          print_r($e);
            echo "Unable to create token";
            
        }

	}
	


    
    

    
    
    function createAccessToken__(){
        
        $code = $_REQUEST['code'];
        $idAndLiveClassId = explode("-",$_REQUEST['id']);
        $id = $idAndLiveClassId[0];
        $liveClassId = $idAndLiveClassId[1];
        
        
        $baseurl = base_url();
        $recurect = $baseurl.'ZoomVideo/createAccessToken?id='.$id.'-'.$liveClassId;
        
        $livedata =$this->db_model->select_data('*','live_class_setting',array('id' =>$liveClassId));
        $appid = $livedata[0]['zoom_api_key'];
        $secretKey = $livedata[0]['zoom_api_secret'];
        $base64 = base64_encode($appid.":".$secretKey);



    
//$url =  "https://zoom.us/oauth/token?grant_type=authorization_code&code=".$code."&redirect_uri=".$recurect;

$curl = curl_init();
curl_setopt_array($curl, array(
  //CURLOPT_URL => "https://zoom.us/oauth/token?grant_type=authorization_code&code=".$code."&redirect_uri=".$recurect,
  CURLOPT_URL => "https://zoom.us/oauth/token?grant_type=account_credentials&code=".$code."&redirect_uri=".$recurect,
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
        echo "Error in aouth token api";
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
               $joinURL  =  json_decode($meetingresponse)->join_url;
               
               // Update Join Url into our database for joining student
               $data_arr=array('join_url'=>$joinURL);
               $this->db_model->update_data_limit('live_class_history',$data_arr,array('id'=>$id),1);
        
               
               echo "<script type=\"text/javascript\">
                window.open('".$startURL."', '_blank')
            </script>";
          }else{
              echo "Something went wrong!!";
          }
      }catch(Exception $e){
          print_r($e);
            echo "Unable to create token";
            
        }



        
    }
    
    
    function startMeeting(){
        
        $code = $_REQUEST['code'];
        $idAndLiveClassId = explode("-",$_REQUEST['id']);
        $id = $idAndLiveClassId[0];
        $liveClassId = $idAndLiveClassId[1];
        
        
        $baseurl = base_url();
        $recurect = $baseurl.'ZoomVideo/createAccessToken?id='.$id.'-'.$liveClassId;
        
        $livedata =$this->db_model->select_data('*','live_class_setting',array('id' =>$liveClassId));
        $appid = $livedata[0]['zoom_api_key'];
        $secretKey = $livedata[0]['zoom_api_secret'];
        $base64 = base64_encode($appid.":".$secretKey);



    
//$url =  "https://zoom.us/oauth/token?grant_type=authorization_code&code=".$code."&redirect_uri=".$recurect;

$curl = curl_init();
curl_setopt_array($curl, array(
  //CURLOPT_URL => "https://zoom.us/oauth/token?grant_type=authorization_code&code=".$code."&redirect_uri=".$recurect,
  CURLOPT_URL => "https://zoom.us/oauth/token?grant_type=account_credentials&code=".$code."&redirect_uri=".$recurect,
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
        echo "Error in aouth token api";
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
               $joinURL  =  json_decode($meetingresponse)->join_url;
               
               // Update Join Url into our database for joining student
               $data_arr=array('join_url'=>$joinURL);
               $this->db_model->update_data_limit('live_class_history',$data_arr,array('id'=>$id),1);
        
               
               echo "<script type=\"text/javascript\">
                window.open('".$startURL."', '_blank')
            </script>";
          }else{
              echo "Something went wrong!!";
          }
      }catch(Exception $e){
          print_r($e);
            echo "Unable to create token";
            
        }



        
    }

    
 

    
}