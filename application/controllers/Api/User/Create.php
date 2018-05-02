<?php

 class Api_User_Create_Controller extends Api_Base_Controller{

     protected function method(): string
     {
         return 'POST';
     }

     protected function rules(): array
     {
         // TODO: Implement rules() method.
         return[
             'student_id'=>'required|digits_between:15,15',
             'password'=>'required',
             'cookie_path'=>'required',
             ];
     }

     protected function messages(): array
     {

         // TODO: Implement messages() method.
         return[
             'student_id.required'=>'学号不能为空',
             'student_id.digits_between'=>'学号为15位',
             'password.required'=>'密码不能为空',
             'cookie_path.required'=>'cookiePath不能为空',
         ];
     }
     protected function process()
     {

         $records = $this->getRequest()->getParams();



         $this->success=true;
         $this->code=200;
         if (Service_User_Model::Store($records)) {

         }else{
             $this->success=false;
         }
     }

}
