<?php 

$servername = "localhost";
$username = "lmhai_app2";
$password = "jayant1307";
$db = "lmhai_app2";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);
 
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$sqlSaltKey = "SELECT key_text,velue_text FROM general_settings WHERE key_text = 'phonepe_salt_key' "; 
$sqlMerchantKey = "SELECT key_text,velue_text FROM general_settings WHERE key_text = 'phonepe_merchant_key' "; 
if ($res = mysqli_query($conn, $sqlSaltKey)) {
    
     if (mysqli_num_rows($res) > 0){
         $row = mysqli_fetch_row($res);
         

         $resMerchange = mysqli_query($conn, $sqlMerchantKey);
         $rowMerchant = mysqli_fetch_row($resMerchange);
         
         
         $event_payload = [
            "merchantId" => $rowMerchant[1],
           // "merchantId" => "PGTESTPAYUAT77",
            "merchantTransactionId" => "MT785".time(),
            "merchantUserId" => "MUID123",
            "amount" => $_GET['amount'],
            "redirectUrl" => "https://app2.lmh-ai.in/success.php",
            "redirectMode" => "POST",
            "callbackUrl" => "https://app2.lmh-ai.in/success.php",
            "mobileNumber" => "9999999999",
            "paymentInstrument" => [
                //"type" => "PAY_PAGE",
                "type" => "UPI_INTENT",
                 "targetApp"  => "com.phonepe.app"
            ],
        ];
        
    
    
         
           $encoded_payload = base64_encode(json_encode($event_payload));
            //$saltKey = "14fa5465-f8a7-443f-8477-f986b8fcfde9";
           // $saltKey = "52873635-cc28-4777-ae90-54e75e630445";
            $saltKey = $row[1];
            $saltIndex = 1;
            $encode = $event_payload;
            $string = $encoded_payload . "/pg/v1/pay" . $saltKey;
            $sha256 = hash("sha256", $string);
            $finalXHeader = $sha256 . "###" . $saltIndex;
            $header = [
                "Content-Type" => "application/json",
                "X-VERIFY" => $finalXHeader,
            ];
        
            $headers = ["Content-Type: application/json", "X-VERIFY:" . $finalXHeader];
        
            //$phone_pay_url ="https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";
            $phone_pay_url ="https://api.phonepe.com/apis/hermes/pg/v1/pay";
            $ch = curl_init($phone_pay_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                json_encode(["request" => $encoded_payload])
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            echo $response;
            die;
            $decodeJson = json_decode($response);
            $paymentUrl = $decodeJson->data->instrumentResponse->redirectInfo->url;
            //header("Location: " . $paymentUrl);
            
    
         
         
     }
     else{
         echo "No data found!";
     }
    
}
else{
    echo "Unable to connect database";
}

 


?>