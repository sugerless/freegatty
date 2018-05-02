<?php
    class Middle_Curl_CurlRequest_Controller {

        public static function Get($path,$timeout = 10){
            $curl=curl_init();

            curl_setopt($curl,CURLOPT_URL,$path);
            curl_setopt($curl,CURLOPT_TIMEOUT,$timeout);


            $responses=curl_exec($curl);


            if(curl_errno($curl))
            {
                return curl_errno($curl);
            }
            curl_close($curl);

            return $responses;

        }
    }