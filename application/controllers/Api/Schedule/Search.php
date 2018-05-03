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
            'swuid'=>'digits_between:15,15|required',
            'term'=>'numeric|max:3|min:0|required',
            'academicYear'=>'numeric|max:3000|min:2000|required',
        ];
    }

    protected function messages(): array
    {
        // TODO: Implement messages() method.

        return [
            'swuid.required'=>'学号不能为空',
            'swuid.digits_between'=>'学号为15位数字',

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
        $results = Service_Schedule_Model::Search_Schedule_NotDIY($Param);

        if ($results->isEmpty()) {
            //getNew data
            //$updateGreade  = Middle_Curl_CurlRequest_Controller::Get(
            //"http://172.18.9.140/api/grade/temp?swuid=".$Param['swuid']."&password=12345");
            $ScheduleData = array(["academicYear"=>2018,"term"=>1,"lessonId"=>"201127",
                    "lessonName"=>"computer vision","teacher"=>"Hello kitty","academicTitle"=>"fujiaoshou",
                    "startTime"=>4,"endTime"=>5,"week"=>5,"day"=>"5","capmus"=>"beiqu",
                    "weekTime"=>"1,2,3,4,5","classroom"=>"25-0901",],
                ["academicYear"=>2018,"term"=>1,"lessonId"=>"201127",
                    "lessonName"=>"computer vision","teacherem"=>"Hello kitty","academicTitle"=>"fujiaoshou",
                    "startTime"=>4,"endTime"=>5,"week"=>5,"day"=>"5","capmus"=>"beiqu",
                    "weekTime"=>"1,2,3,4,5","classroom"=>"25-0901"],
            );
            Service_Schedule_Model::Save_Schedule_NotDIY($Param['swuid'],$ScheduleData);

        }


        foreach ($results as $result) {
            $node = array(
                "score" => $result->score,
                "lessonName" => $result->lesson_name,
                "academicYear" => $result->academic_year,
                "term" => $result->term,
                "gradePoint" => $result->grade_point,
                "credit" => $result->credit,
                "examType" => $result->exam_type,
                "lessonType" => $result->lesson_type,
            );
            array_push($this->data, $node);
        }
        $this->msg="查询成功";
        $this->success=true;
        $this->code=200;


    }
}