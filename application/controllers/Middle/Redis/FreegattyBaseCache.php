<?php

class Middle_Redis_FreegattyBaseCache_Controller extends Middle_Redis_Base_Controller{
        //增加set和get方法，封装redis的相关操作 by suger 2018 5.6
        public function Set($key,$value,$time){
            $this->redis->setex($key,$time,$value);
        }

        public function Get($key){
            return $this->redis->get($key);
        }
}