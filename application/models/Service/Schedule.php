<?php

class Service_Schedule_Model extends Service_Base_Model
{

    public static function All_Record(){
        $records = Dao_Schedule_Model::all();
        return $records;
    }

    public static function Search_Schedule($swuid,$SearchParam,$IsDIY){

        $condition = [['swuid', '=', $swuid],
            ['academic_year', '=', $SearchParam["academicYear"]],
            ['term', '=', $SearchParam["term"]],
            ['DIY', '=', $IsDIY?1:0],
        ];
        $records = Dao_Schedule_Model::where($condition)->select('*')->get();
        return $records;
    }
    public static function Search_Schedule_All($swuid,$SearchParam){

        $condition = [['swuid', '=', $swuid],
            ['academic_year', '=', $SearchParam["academicYear"]],
            ['term', '=', $SearchParam["term"]],
        ];
        $records = Dao_Schedule_Model::where($condition)->select('*')->get();
        return $records;
    }
    public static function Has_Schedule_DIY($swuid,$LessonId){

        $condition = [['swuid', '=', $swuid],
            ['lesson_id', '=', $LessonId],
            ['DIY', '=', 1],
        ];
        $records = Dao_Schedule_Model::where($condition)->select('*')->get();
        return $records;
    }
    public static function Delete_Schedule($swuid,$LessonId)
    {
        $condition = [['swuid', '=', $swuid],
            ['lesson_id', '=', $LessonId],
            ['DIY', '=', 1],
        ];
        $records = Dao_Schedule_Model::where($condition)->delete();
        return $records;

    }
    public static function Save_Schedule($swuid,$ScheduleData,$IsDIY){
        if($IsDIY) {
            $cord = new Dao_Schedule_Model();
            $cord->swuid = $swuid;
            $cord->academic_year = $ScheduleData->academicYear;
            $cord->lesson_id = $ScheduleData->lessonId;
            $cord->term = $ScheduleData->term;
            $cord->lesson_name = $ScheduleData->lessonName;
            $cord->classroom = $ScheduleData->classroom;
            $cord->teacher = $ScheduleData->teacher;
            $cord->academic_title = $ScheduleData->academicTitle;
            $cord->start_time = $ScheduleData->startTime;
            $cord->end_time = $ScheduleData->endTime;
            $cord->week = $ScheduleData->week;
            $cord->campus = $ScheduleData->campus;
            $cord->week_time = $ScheduleData->weeks;
            $cord->DIY = 1;
            return $cord->save();
        }else{
            $condition = [
                ['swuid', '=', $swuid],
                ['DIY', '=', 0],
            ];
            Dao_Schedule_Model::where($condition)->delete();
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
                $cord->campus = $Schedule['campus'];
                $cord->week_time = $Schedule['weekTime'];
                $cord->DIY = 0;
                return $cord->save();
            }
        }
    }
    public static function Modify_Schedule($swuid,$ScheduleData){

        $codition=[
            ['swuid','=',$swuid],
            ['lesson_id','=',$ScheduleData->lessonId]
        ];
        $cord=Dao_Schedule_Model::where($codition)->get();
        $cord=$cord->first();

        $cord->academic_year = $ScheduleData->academicYear;
        $cord->term = $ScheduleData->term;
        $cord->lesson_name = $ScheduleData->lessonName;
        $cord->classroom = $ScheduleData->classroom;
        $cord->teacher = $ScheduleData->teacher;
        $cord->academic_title = $ScheduleData->academicTitle;
        $cord->start_time = $ScheduleData->startTime;
        $cord->end_time = $ScheduleData->endTime;
        $cord->week = $ScheduleData->week;
        $cord->campus = $ScheduleData->campus;
        $cord->week_time = $ScheduleData->weeks;
        return $cord->save();
    }
}
