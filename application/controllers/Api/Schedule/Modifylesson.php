<?php

class Api_Schedule_ModifyLesson_Controller extends Api_Base_Controller
{

    protected function method(): string
    {
        return 'POST';
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.

        return [
            'academicYear'=>'numeric|max:3000|min:2000|required',
            'term'=>'numeric|max:3|min:0|required',
            'lessonId'=>'required',
            'lessonName'=>'required',
            'teacher'=>'required',
            'academicTitle'=>'required',
            'startTime'=>'required|numeric|max:12|min:0',
            'endTime'=>'required|numeric|max:12|min:0',
            'weeks'=>'required|array',
            'day'=>'required|max:8|min:0',
            'week'=>'required',
            'campus'=>'required',
            'classRoom'=>'required',
        ];
    }

    protected function messages(): array
    {


        // TODO: Implement messages() method.
        return [
            'academicYear.required'=>'学年不能为空',
            'term.required'=>'学期不能为空',
            'lessonId.required'=>'课程ID不能为空',
            'lessonName.required'=>'课程名不能为空',
            'teacher.required'=>'教师名不能为空',
            'academicTitle.required'=>'教师职称不能为空',
            'startTime.required'=>'开始时间不能为空',
            'endTime.required'=>'结束时间不能为空',
            'weeks.required'=>'周数不能为空',
            'day.required'=>'课程所在星期不能为空',
            'week.required'=>'week不能为空',
            'campus.required'=>'校区不能为空',
            'classRoom.required'=>'教室不能为空',
        ];
    }

    protected function process()
    {

        //$Param = json_decode(file_get_contents('php://input'));
        // 获取参数的逻辑放在base.php,actionAuth中，这里兼容后面写法将数组强制转化为对象
        // by suger
        // 2018 5.5

        $Param=(object)$this->Param;
        $Param->weeks = implode(",",$Param->weeks);

        $token = $_SERVER['HTTP_ACTOKEN'];
        $redis=new Middle_Redis_FreegattyBaseCache_Controller();
        $user=json_decode($redis->Get($token));

        if($user->swuid == null || $user->swuPassword == null){
            $this->msg="请绑定校园网账号";
            $this->code=400;
            return;
        }

        $swuid = $user->swuid;

        $results = Service_Schedule_Model::Has_Schedule_DIY($swuid,$Param->lessonId);
        if($results->isEmpty()) {
            Service_Schedule_Model::Save_Schedule($swuid, $Param, true);
            $this->msg = "添加课程成功";

        }else{
            Service_Schedule_Model::Modify_Schedule($swuid, $Param, true);
            $this->msg="修改课程成功";

        }

        $this->success = true;
        $this->code = 200;


    }
}