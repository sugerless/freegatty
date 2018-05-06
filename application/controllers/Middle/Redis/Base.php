<?php
use SwuOS\Openapi\Exception\SystemErrorException;

class Middle_Redis_Base_Controller {
    protected $redis;
    //连接redis by suger 2018 5.6
        function __construct(){
            try {
                $this->redis = new Redis();
                $this->redis->connect('redis', 6379);
            }
            catch (Exception $e){
                new SystemErrorException();
            }
        }
    }
