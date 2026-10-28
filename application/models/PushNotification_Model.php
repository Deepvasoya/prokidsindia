<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 require_once APPPATH.'/third_party/googleclient/vendor/autoload.php'; 

class PushNotification_Model extends CI_Model{ 
     
    function __construct() { 
        $this->proTable   = 'products'; 
    } 
    
    
    function letSendWithToken($token,$title='Test',$body='Test bidy'){
        $data = ['key' => 'value'];
        //$this->sendFCMNotification($token, $title, $body, $data);
        $topic = 'varsha testing';
        $this->sendNotificationTest($token, $title, $body);
    }
    
    
     function letSend(){
        $token = "dRsLinkBSq-zoCRLIHjWrf:APA91bFcSao9UBMGBUS7xEkkML_uDsT2AQS7FyIXV4wUaldL_t2OC_Nk5hJjwYbJd4OCyvkHi0AxQMs-iO5iXGYN_XdCyHH_U1poh6KQz3Ou5uLY2ctnY8WjoZq8TMBZoYnAYI2ZYIbW"; //FCM Device token
        $title = "Test from PHP";
        $body = "This is a test from PHP";
        $data = ['key' => 'value'];

        //$this->sendFCMNotification($token, $title, $body, $data);
        $topic = 'varsha testing';
        $this->sendNotificationFromTopic($token, $title, $body);
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
    
        // echo "\n\n======RESPONSE======\n\n";
        // echo $result;
        return true;
    
    }
    
    function sendNotificationFromTopic($topic, $title, $body) {
        $topic = str_replace(' ', '', $topic);

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
    
    
    
function getOATHTokenTest(){
    $client = new Google_Client();
    try {
        //$client->setAuthConfig(APPPATH.'/firebase/testservice.json');
        $client->setAuthConfig(APPPATH.'/firebase/fruitrack.json');
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


    function sendNotificationTest($token, $title, $body) {
        $accessToken = $this->getOATHTokenTest();
        $payload = ["message" => ["token" => $token, "notification"=>["title" => $title, "body"=> $body], "data"=>["title" => $title, "body"=> $body]]];
    
        
            $headers = array
            (
            'Authorization: Bearer '.$accessToken,
            'Content-Type: application/json'
            );
            #Send Reponse To FireBase Server    
            $ch = curl_init();
            //curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/dgdiary-151314/messages:send' );
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/fruitrack-9ecfa/messages:send' );
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
        return true;
    
    }

    
     
}