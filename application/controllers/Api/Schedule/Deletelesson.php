<?php

class Api_Schedule_deleteLesson_Controller extends Api_Base_Controller
{
    protected function method(): string
    {
        return 'GET';
    }

    protected function rules(): array
    {
        // TODO: Implement rules() method.

        return [
            'lessonId'=>'required',

        ];
    }

    protected function messages(): array
    {


        // TODO: Implement messages() method.
        return [
            'lessonId.required'=>'lesson ID不能为空',
        ];
    }

    protected function process()
    {

        $Param = $this->getRequest()->getParams();
        $lessonId = $Param["lessonId"];

        $token = $_SERVER['HTTP_ACTOKEN'];
        $redis=new Middle_Redis_FreegattyBaseCache_Controller();
        $user=json_decode($redis->Get($token));

        if($user->swuid == null || $user->swuPassword == null){
            $this->msg="请绑定校园网账号";
            $this->code=400;
            return;
        }

        $swuid = $user->swuid ;

        $results = Service_Schedule_Model::Has_Schedule_DIY($swuid,$lessonId);
        if($results->isEmpty()) {
            $this->msg="找不到对应课程，删除失败";
            $this->code = 400;
            return;
        }else{
            Service_Schedule_Model::Delete_Schedule($swuid, $Param);
            $this->msg = "删除课程成功";
            $this->success = true;
            $this->code = 200;
        }


    }
}