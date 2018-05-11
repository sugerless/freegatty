<?php

class Api_Grade_Search_Controller extends Api_Base_Controller
{
    protected function method(): string
    {
        return 'GET';
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'term'=>'numeric|max:3|min:0',
            'academicYear'=>'numeric|max:3000|min:2000',
        ];
    }

    protected function messages(): array
    {
        // TODO: Implement messages() method.

        return [

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

        $token = $_SERVER['HTTP_ACTOKEN'];
        $redis=new Middle_Redis_FreegattyBaseCache_Controller();
        $user=json_decode($redis->Get($token));

        if($user->swuid == null || $user->swuPassword == null){
            $this->msg="请绑定校园网账号";
            $this->code=400;
            return;
        }

        $Param["swuid"] = $user->swuid;
        $results = Service_Score_Model::Search_Score($Param);

        if ($results->isEmpty()) {

            $gradeData  = Middle_Curl_CurlRequest_Controller::Get(
                "/queryGrade?swu_id=".$user->swuid."&password=".$user->swuPassword);
            $gradeData = json_decode($gradeData,true);
            if(!$gradeData['success']){
                $this->msg=$gradeData['message'];
                $this->success=false;
                $this->code=200;
                return;
            }else {
                $gradeData = $gradeData['result']['data'];
                Service_Score_Model::Save_Score($user->swuid,$gradeData);
            }

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
