<?php

class Service_User_Model extends Service_Base_Model{
    public static function Get_Cookie($student_id){
        $codition=[
            ['student_id','=',$student_id]
        ];
        $cord=Dao_User_Model::where($codition)->get();
        if($cord->isEmpty()){
            return false;
        }
        else{
            return $cord->first()->cookie_path;
        }
    }
    public static function Store($record){
        $codition=[
            ['student_id','=',$record['student_id']],
            ['password','=',$record['password']]
        ];
        $cord=Dao_User_Model::where($codition)->get();
        if($cord->isEmpty()){
            $cord=new Dao_User_Model();
        }
        else{
            $cord=$cord->first();
        }

        $cord->student_id=$record['student_id'];
        $cord->password=$record['password'];
        $cord->cookie_path=$record['cookie_path'];

        if($cord->save()){
            return true;
        }
        else{
            return false;
        }
    }
}
