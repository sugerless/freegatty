<?php


class Middle_Redis_Base_Controller {
        public static function setRedisConnection(){
            $redis=new Redis();
            $redis->connect('redis',6379);
            //$redis->connect('redis',6379);
            return $redis;
        }
    }
