<?php

class Service_Schedule_Model extends Service_Base_Model
{

    public static function All_Record(){
        $records = Dao_Schedule_Model::all();
        return $records;
    }

    public static function Search_Schedule_NotDIY($SearchParam){
        $condition = [  ['swuid','=',$SearchParam["swuid"]],
                        ['academic_year','=',$SearchParam["academicYear"]],
                        ['term','=',$SearchParam["term"]],
                        ['DIY','=',0],
            ];
        $records= Dao_Schedule_Model::where($condition)->select('*')->get();
        return $records;
    }

    public static function Save_Schedule_NotDIY($swuid,$ScheduleData){
        $condition=[
            ['swuid','=',$swuid],
            ['DIY','=',0],
        ];
        Dao_Schedule_Model::where($condition)->delete();

        print_r("delete success");
        foreach ($ScheduleData as $Schedule) {
            $cord = new Dao_Schedule_Model();
            $cord->swuid = $swuid;
            $cord->academic_year = $Schedule['academicYear'];
            $cord->lesson_id = $Schedule['lessonId'];
            $cord->term = $Schedule['term'];
            $cord->lesson_name = $Schedule['lessonName'];
            $cord->classroom = $Schedule['classroom'];
            $cord->teacher = $Schedule['teacher'];
            $cord->academic_title = $Schedule['academicTitle'];
            $cord->start_time = $Schedule['startTime'];
            $cord->end_time = $Schedule['endTime'];
            $cord->week = $Schedule['week'];
            $cord->capmus = $Schedule['capmus'];
            $cord->week_time = $Schedule['weekTime'];
            $cord->DIY = 0;
            $cord->save();
        }
    }

}
