<?php

use SwuOS\Openapi\Exception\CustomException;
use SwuOS\Openapi\Exception\InvalidRequestMethodException;
use SwuOS\Openapi\Exception\NeedLoginException;
use SwuOS\Openapi\Exception\UnsupportedRequestMethodException;
use SwuOS\Openapi\Exception\InvalidParamsTypeException;
use SwuOS\Openapi\Library\Log;
use Illuminate\Container\Container;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Yaf\Controller_Abstract;

abstract class Api_Base_Controller extends Controller_Abstract
{
    protected $needLogin = false;
    protected $success = false;
    protected $code = "200";
    protected $data =[];
    protected $msg="";
    protected $Param;
    //将需要特殊参数的controller写在这里 by suger 2018 5.5
    protected $arrNeedSpecialParam=[
        'json'=>['Api_Schedule_Addlesson',
                 'Api_Schedule_Modifylesson',
        ],
    ];

    /**
     * 参数校验规则
     *
     * @return array
     */
    abstract protected function rules(): array;

    /**
     * 参数校验失败提示文案
     *
     * @return array
     */
    abstract protected function messages(): array;

    /**
     * 业务逻辑方法
     *
     * @return mixed
     */
    abstract protected function process();

    /**
     * 设置接口请求方式
     *
     * @return string
     */
    protected function method(): string
    {
        return 'POST';
    }

    /**
     * @throws InvalidRequestMethodException
     * @throws UnsupportedRequestMethodException
     */
    public function init()
    {

        if ($this->getRequest()->method !== $this->method()) {
		throw new InvalidRequestMethodException();
        }

        switch ($this->method()) {
            case 'GET':
                $parameters = $_GET;
                break;
            case 'POST':
                $parameters = $_POST;
                break;
            default:
                throw new UnsupportedRequestMethodException($this->method());
        }

        $this->getRequest()->setParam($parameters);
    }

    public function indexAction()
    {

        try {

            $this->auth();
            $this->validate();
            $this->process();
            $this->response($this->success,$this->data,$this->code,$this->msg);

        } catch (CustomException $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            $this->response($this->success,[], $e->getCode(), $e->getMessage());
        } catch (ValidationException $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            foreach ($e->errors() as $field => $error) {
                $this->response($this->success,[], 500, $error[0] ?? $field . '无效');
                break;
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            $this->response($this->success,[], 500, '系统错误'.$e->getMessage());
        } finally {
            Log::info('input', $this->getRequest()->getParams());
        }
        //$this->process();
    }

    protected function response($success=true, array $data, int $code = 0, string $message = 'success')
    {
        $responseData = [
            'success' => $success,
            'message'   => $message,
            'result'  => empty($data) ? new stdClass() : $data,
        ];

        Log::info('output', $responseData);

        headers_sent() || header('Content-Type: application/json');

        $this->getResponse()->setBody(json_encode($responseData, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 校验参数
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validate()
    {
        $factory = new Factory(new Translator(new ArrayLoader(), ''), Container::getInstance());
        if(!empty($this->getRequest()->getParams()))
            $factory->validate($this->getRequest()->getParams(), $this->rules(), $this->messages(), []);

        //对特殊参数进行参数验证 by suger 2018 5.5
        else{
            if(empty($this->Param))
                throw new InvalidParamsTypeException();
            $factory->validate($this->Param, $this->rules(), $this->messages(), []);
        }
    }

    protected function auth()
    {

        if ($this->needLogin === false) {
            return true;
        }
        //对所有请求进行验证 by suger 2018 5.6
        if (Middle_Token_Validate_Controller::Validate()===true) {

            //对参数类型为json的controller设置参数 by suger 2018 5.5
            if (in_array($this->getRequest()->getControllerName(), $this->arrNeedSpecialParam['json'])) {
                $this->Param = json_decode(file_get_contents('php://input'), true);
                return true;
            }
            return true;
        }

        throw new NeedLoginException();
    }

}
