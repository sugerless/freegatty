<?php

class Service_Schedule_Model extends Service_Base_Model
{

    public static function All_Record(){
        $records = Dao_Schedule_Model::all();
        return $records;
    }

    public static function Search_Schedule($student_id,$academic_year,$term){
        $condition = [['student_id','=',$student_id],
            ['academic_year','=',$academic_year],
            ['term','=',$term]];
        $records= Dao_Schedule_Model::where($condition)->select('*')->get();
        return $records;
    }

    public static function Store($record){

        $condition=[
            ['student_id',$record['student_id']],
            ['lesson_content',$record['lesson_content']],
            ['academic_year',$record['academic_year']],
            ['term',$record['term']],
        ];

        $cord=Dao_Schedule_Model::where($condition)->get();
        if($cord->isEmpty()) {
            $cord = new Dao_Schedule_Model();
        }
        else{
            $cord=$cord->first();
        }
        $cord->student_id=$record['student_id'];
        $cord->lesson_content=$record['lesson_content'];
        $cord->academic_year=$record['academic_year'];
        $cord->term=$record['term'];
        return $cord->save() ;
    }

}
