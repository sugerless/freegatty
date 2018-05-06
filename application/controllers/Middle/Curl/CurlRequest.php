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
        //添加Post方法，封装了php curl的一些设置 by suger 2018 5.6
        public static function Post($url,$arrData,$timeout=10)
        {
            if(empty($url)||empty($arrData)){
                return false;
            }
            $postUrl=$url;
            $postData=json_encode($arrData);

            $curl=curl_init();
            curl_setopt($curl,CURLOPT_URL,$postUrl);
            curl_setopt($curl,CURLOPT_HEADER,0);
            curl_setopt($curl,CURLOPT_TIMEOUT,$timeout);
            curl_setopt($curl,CURLOPT_POST,1);
            curl_setopt($curl,CURLOPT_POSTFIELDS,$postData);

            $res=curl_exec($curl);
            curl_close($curl);

            return $res;

        }
    }