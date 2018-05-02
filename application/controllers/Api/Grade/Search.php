<?php

class Api_Grade_Search_Controller extends Api_Base_Controller
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
            'term'=>'numeric|max:3|min:0',
            'academicYear'=>'numeric|max:3000|min:2000',
        ];
    }

    protected function messages(): array
    {
        // TODO: Implement messages() method.
        $Param = $this->getRequest()->getParams();
        print_r($Param);
        return [
            'swuid.required'=>'学号不能为空',
            'swuid.digits_between'=>'学号为15位数字',

            'term.numeric'=>'学期必须为数字',
            'term.max'=>'学期数必须为1,2,3',
            'term.min'=>'学期数必须为1,2,3',

            'academicYear.numeric'=>'学年必须为数字',
            'academicYear.max'=>'请输入正确的学年数',
            'academicYear.min'=>'请输入正确的学年数',
        ];
    }

    protected function process()
    {

        $Param = $this->getRequescdghlnyt()->getParams();
        $results = Service_Score_Model::Search_Score($Param);

        if ($results->isEmpty()) {
            print_r("hasNew");
            //getNew data
            //$updateGreade  = Middle_Curl_CurlRequest_Controller::Get(
                //"http://172.18.9.140/api/grade/temp?swuid=".$Param['swuid']."&password=12345");
            $gradeData = array(
                ["score"=> 85,"term"=>1,"lessonId"=>201127,"credit"=>"4.0","academicYear"=>2018,
                    "lessonName"=>"computer vision","teacher"=>"Hello kitty","department"=>"jixinyan",
                    "examType"=>"normalExam","lessonType"=>"mustKao","gradePoint"=>5],
                ["score"=> 85,"term"=>1,"lessonId"=>2012347,"credit"=>"4.0","academicYear"=>2017,
                    "lessonName"=>"computer vision","teacher"=>"Hello kitty","department"=>"jixinyan",
                    "examType"=>"normalExam","lessonType"=>"mustKao","gradePoint"=>5],
            );
            Service_Score_Model::Save_Score($Param['swuid'],$gradeData);

        }


        foreach ($results as $result) {
            $node = array(
                "swuid" => $result->swuid,
                "score" => $result->score,
                "term" => $result->term,
                "lessonId" => $result->lesson_id,
                "credit" => $result->credit,
                "academicYear" => $result->academic_year,
                "lessonName" => $result->lesson_name,
                "teacher" => $result->teacher,
                "examType" => $result->exam_type,
                "lessonType" => $result->lesson_type,
                "gradePoint" => $result->grade_point,
            );
            array_push($this->data, $node);
        }
        $this->msg="查询成功";
        $this->success=true;
        $this->code=200;


    }
}