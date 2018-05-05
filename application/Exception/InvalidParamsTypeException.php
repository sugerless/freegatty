<?php

namespace SwuOS\Openapi\Exception;

use Throwable;

class InvalidParamsTypeException extends CustomException
{
    public function __construct(string $message="无效的参数类型，请检查参数格式", int $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}