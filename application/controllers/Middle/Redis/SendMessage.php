<?php

class Middle_Redis_SendMessage_Controller extends Middle_Redis_Base_Controller{
     public static function Send(array $message){
         $redis=parent::setRedisConnection();

         $messages=json_encode($message,JSON_UNESCAPED_UNICODE);
         echo $messages,"<br/>";
         $redis->lPush("freegatty",$messages);

         echo "successful";

         #print_r($redis->lRange("login-list",0,-1));

     }
}
