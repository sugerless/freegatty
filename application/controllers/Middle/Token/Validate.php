<?php
    use SwuOS\Openapi\Exception\SystemErrorException;

    class Middle_Token_Validate_Controller {
        //先去缓存中查找，若没有再请求授权中心获得授权并更新缓存，账户缓存有效期12h
        // by suger 2018 5.6
        public static function Validate(){

            if(isset($_SERVER['acToken'])) {
                $token = $_SERVER['acToken'];
            }
            else{
                return false;//token字段不存在
            }

            $redis=new Middle_Redis_FreegattyBaseCache_Controller();
            $res=$redis->Get($token);
            if(empty($res)) {
                $strUrl='http://{server_url}/token/check';
                $arrData = [
                    'acToken' => $token
                ];
                $res = Middle_Curl_CurlRequest_Controller::Post($strUrl, $arrData);
                if ($res) {
                    $arrResponse = json_decode($res, true);
                    if ($arrResponse['success'] == true) {
                        $arrUserInfo = json_encode($arrResponse['result']);
                        $redis->Set($token, $arrUserInfo, 43200);
                        return true;//token验证成功
                    } else {
                        return false;//token验证失败
                    }
                }
                else {
                    new SystemErrorException();
                }
            }
            else{
                return true;//token验证成功
            }
        }
    }
