<?php

class Api_Schedule_Search_Controller extends Api_Base_Controller
{
    protected function method(): string
	{
		return 'GET';
	}

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'student_id'=>'digits_between:15,15|required',
            'term'=>'numeric|max:3|min:0|required',
            'academic_year'=>'numeric|max:3000|min:2000|required',
			
        ];
    }

    protected function messages(): array
    {
        // TODO: Implement messages() method.
        return [
            'student_id.required'=>'学号不能为空',
            'student_id.digits_between'=>'学号为15位数字',

            'term.required'=>'学期不能为空',
            'term.numeric'=>'学期必须为数字',
            'term.max'=>'学期数必须为1,2,3',
            'term.min'=>'学期数必须为1,2,3',

            'academic_year.required'=>'学年不能为空',
            'academic_year.numeric'=>'学年必须为数字',
            'academic_year.max'=>'请输入正确的学年数',
            'academic_year.min'=>'请输入正确的学年数',
            ];
    }

    protected function process()
    {

        $Param = $this->getRequest()->getParams();
        $results = Service_Schedule_Model::Search_Schedule($Param['student_id'], $Param['academic_year'], $Param['term']);

        if ($results->isEmpty()) {
            Middle_Redis_SendMessage_Controller::Send(["type" => "schedule"
                , "param" => ["student_id" => $Param['student_id']
                    , "academic_year" => $Param['academic_year']
                    , "term" => $Param['term']
                    , "cookie_path" => Service_User_Model::Get_Cookie($Param['student_id'])]]);
            $time_array = array(30,60);
            foreach ($time_array as $time){

                sleep($time / 1000.0);
                $results = Service_Schedule_Model::Search_Schedule($Param['student_id'], $Param['academic_year'], $Param['term']);
                if ($results->isEmpty()) continue;
            }
        }


        foreach ($results as $result) {


            array_push($this->data, $result->lesson_content);
        }
        $this->msg="查询成功";
        $this->success=true;
        $this->code=200;


    }
}