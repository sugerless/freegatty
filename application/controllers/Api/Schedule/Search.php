<?php

class Api_Schedule_Search_Controller extends Api_Base_Controller
{
    protected function method(): string
    {
        return 'POST';
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'term'=>'numeric|max:3|min:0|required',
            'academicYear'=>'numeric|max:3000|min:2000|required',
        ];
    }

    protected function messages(): array
    {
        // TODO: Implement messages() method.

        return [

            'term.numeric'=>'学期必须为数字',
            'term.max'=>'学期数必须为1,2,3',
            'term.min'=>'学期数必须为1,2,3',
            'term.required'=>'学期不能为空',

            'academicYear.required'=>'学年不能为空',
            'academicYear.numeric'=>'学年必须为数字',
            'academicYear.max'=>'请输入正确的学年数',
            'academicYear.min'=>'请输入正确的学年数',
        ];
    }

    protected function process()
    {

        $Param = $this->getRequest()->getParams();

        $token = $_SERVER['HTTP_ACTOKEN'];
        $redis=new Middle_Redis_FreegattyBaseCache_Controller();
        $user=json_decode($redis->Get($token));

        if($user->swuid == null || $user->swuPassword == null){
            $this->msg="请绑定校园网账号";
            $this->code=400;
            return;
        }

        $swuid = $user->swuid;

        $results = Service_Schedule_Model::Search_Schedule($swuid,$Param,false);

        if ($results->isEmpty()) {

            $ScheduleData  = Middle_Curl_CurlRequest_Controller::Get(
                "/querySchedule?swu_id=".$user->swuid."&password=".$user->swuPassword);
            $ScheduleData = json_decode($ScheduleData,true);
            if(!$ScheduleData['success']){
                $this->msg=$ScheduleData['message'];
                $this->success=false;
                $this->code=200;
                return;
            }else {
                $ScheduleData = $ScheduleData['result']['data'];
                Service_Schedule_Model::Save_Schedule($user->swuid,$ScheduleData,false);
            }

        }
        $results = Service_Schedule_Model::Search_Schedule_All($swuid,$Param);
        for ($i = 1; $i <= 20;$i++){
            array_push($this->data, array(
                "weekSort"=>$i,
                "weekitem"=>[],

            ));
        }
        $weeks = array("星期一"=>1, "星期二"=>2,"星期三"=>3,"星期四"=>4,"星期五"=>5, "星期六"=>6,"星期天"=>7);
        foreach ($results as $result) {
            $weekTime = explode(",",$result->week_time);
            $node = array(
                "academicYear" => $result->academic_year,
                "term" => $result->term,
                "lessonId" => $result->lesson_id,
                "lessonName" => $result->lesson_name,
                "teacher" => $result->teacher,
                "academicTitle" => $result->academic_title,
                "startTime" => $result->start_time,
                "endTime" => $result->end_time,
                "day" => $weeks[$result->week],
                "week" => $result->week,
                "campus" => $result->campus,
                "classRoom" => $result->classRoom,
            );
            foreach ($weekTime as $week){
                array_push($this->data[(int)$week -1]["weekitem"],$node);
            }

        }
        $this->msg="查询成功";
        $this->success=true;
        $this->code=200;
    }
}