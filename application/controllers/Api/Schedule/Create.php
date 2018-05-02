<?php


class Api_Schedule_Create_Controller extends Api_Base_Controller
{
    protected function method(): string
	{
		return 'POST';
	}
    protected function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            'student_id'=>'digits_between:15,15|required',
            'academic_year'=>'numeric|max:3000|min:2000|required',
			'lesson_content'=>'required',
            'term'=>'numeric|max:3|min:0|required',

        ];
    }

    protected function messages(): array
    {

        // TODO: Implement messages() method.
        return [
            'student_id.required'=>'学号不能为空啊',
            'student_id.digits_between'=>'学号为15位数字',

            'lesson_content.required'=>'课程信息不能为空',

            'academic_year.required'=>'学年不能为空',

            'term.required'=>'学期不能为空',
            'term.numeric'=>'学期必须为数字',
            'term.max'=>'学期数必须为1,2,3',
            'term.min'=>'学期数必须为1,2,3',


        ];
    }

    protected function process()
    {
        // TODO: Implement process() method.

        $records=$this->getRequest()->getParams();
		
        if(Service_Schedule_Model::Store($records)) {
            $this->success=true;
			$this->msg="添加课程信息成功";
            $this->code=200;
        }else{
			$this->success=false;
			$this->msg="添加课程信息失败，错误未知";
            $this->code=401;
		}
    }


}
