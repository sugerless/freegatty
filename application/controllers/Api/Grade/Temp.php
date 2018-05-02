<?php

class Api_Grade_Temp_Controller extends Api_Base_Controller
{
    protected function method(): string
    {
        return 'GET';
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'swuid'=>'digits_between:15,15|required',
            'password'=>'numeric',
        ];
    }

    protected function messages(): array
    {
        // TODO: Implement messages() method.
        $Param = $this->getRequest()->getParams();

        return [
            'swuid.required'=>'学号不能为空',
            'swuid.digits_between'=>'学号为15位数字',

        ];
    }

    protected function process()
    {
        $Param = $this->getRequest()->getParams();


        $this->data = array(
            ["academicYear"=>2017,"term"=>1,"lessonId"=>2017,
                "lessonName"=>"computer vision","teacher"=>"Hello kitty",
                "academicTitle"=>"professor","startTime"=>4,
                "endTime"=>5,"week"=>"xinqisan",
                "campus"=>"beiqu","classroom"=>"08-209",
                "weekTime"=>"1,2,3,4,5"],
            ["academicYear"=>2017,"term"=>1,"lessonId"=>2017,
                "lessonName"=>"computer program","teacher"=>"Hello world",
                "academicTitle"=>"professor","startTime"=>4,
                "endTime"=>5,"week"=>"xinqisan",
                "campus"=>"beiqu","classroom"=>"08-209",
                "weekTime"=>"1,2,3,4,5"]
        );
        $this->msg="查询成功";
        $this->success=true;
        $this->code=200;


    }
}