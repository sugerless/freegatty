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

        $Param = $this->getRequest()->getParams();
        $results = Service_Score_Model::Search_Score($Param);

        if ($results->isEmpty()) {
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