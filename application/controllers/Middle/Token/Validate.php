<?php
    use \Firebase\JWT\JWT;

    class Middle_Token_Validate_Controller {
        public static function Validate(){
            return 1;
            if(isset($_SERVER['HTTP_TOKEN']))
                $jwt=$_SERVER['HTTP_TOKEN'];
            else
                return -3;//token字段不存在

            $key="341204";
            $decoded=JWT::decode($jwt,$key,array('HS256'));
            if(!$decoded)
                return -1;//token错误
            $decoded_array=(array)$decoded;
            if(!$decoded_array["student_id"])
                return -1;//token错误
            else {
                $begintime=$decoded_array['time'];
                $t=time();
                $timediff=$t-$begintime;
                $remain = $timediff%86400;
                $hours = intval($remain / 3600);
                if($hours>12){
                    return -2;//token过期
                }
                return 1;//通过验证
            }
        }
    }
