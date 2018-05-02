<?php

class Service_Score_Model extends Service_Base_Model
{

    public static function All_Record(){
        $records = Dao_Score_Model::all();
        return $records;
    }

    public static function Search_Score($Search){
        $condition = [['swuid','=',$Search["swuid"]]];
        if(isset($Search['academicYear'])){
            array_push($condition,['academic_year','=',$Search["academicYear"]]);
            if(isset($Search['term'])) {
                array_push($condition,['term','=',$Search["term"]]);
            }
        }
        $records= Dao_Score_Model::where($condition)->select('*')->get();
        return $records;
    }

    public static function Save_Score($swuid,$gradeData){

        $condition=[
            ['swuid',$swuid],
        ];
        Dao_Score_Model::where($condition)->delete();

        print_r("delete success");
        foreach ($gradeData as $grade){
            $cord = new Dao_Score_Model();
            $cord->swuid = $swuid;
            $cord->academic_year = $grade['academicYear'];
            $cord->term = $grade['term'];
            $cord->lesson_name = $grade['lessonName'];
            $cord->score = $grade['score'];
            $cord->credit = $grade['credit'];
            $cord->teacher = $grade['teacher'];
            $cord->department = $grade['department'];
            $cord->grade_point = $grade['gradePoint'];
            $cord->exam_type = $grade['examType'];
            $cord->lesson_type = $grade['lessonType'];
            print_r($grade);
            $cord->save();
        }


        return ;
    }

}
