<?php 
//application/libraries/CreatorJwt.php
    require APPPATH . '/libraries/JWT.php';

    class CreatorJwt
    {
       

        /*************This function generate token private key**************/ 

        //PRIVATE $key = "N48vhSoEhnoeyi37uydJY7sybkRl4myc"; 
        public function GenerateToken($data,$key)
        {     
            
            $jwt = JWT::encode($data, $key);
            return $jwt;
        }
        

       /*************This function DecodeToken token **************/

        public function DecodeToken($token)
        {          
            $decoded = JWT::decode($token, $this->key, array('HS256'));
            $decodedData = (array) $decoded;
            return $decodedData;
        }
    }