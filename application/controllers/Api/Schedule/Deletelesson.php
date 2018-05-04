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

        $swuid = "222015321210005";

        $results = Service_Schedule_Model::Has_Schedule_DIY($swuid,$lessonId);
        if($results->isEmpty()) {
            $this->msg="can't find this lesson";
            $this->code = 400;
            return;
        }else{
            Service_Schedule_Model::Delete_Schedule($swuid, $Param);
            $this->msg = "delete schedule success";
            $this->success = true;
            $this->code = 200;
        }


    }
}