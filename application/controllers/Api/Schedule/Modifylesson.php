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


        ];
    }

    protected function messages(): array
    {


        // TODO: Implement messages() method.
        return [

        ];
    }

    protected function process()
    {

        $Param = json_decode(file_get_contents('php://input'));

        $Param->weeks = implode(",",$Param->weeks);
        $swuid = "222015321210005";

        $results = Service_Schedule_Model::Has_Schedule_DIY($swuid,$Param->lessonId);
        if($results->isEmpty()) {
            Service_Schedule_Model::Save_Schedule($swuid, $Param, true);
            $this->msg = "add schedule sucess";

        }else{
            Service_Schedule_Model::Modify_Schedule($swuid, $Param, true);
            $this->msg="modify success this lesson";

        }
        $this->success = true;
        $this->code = 200;


    }
}