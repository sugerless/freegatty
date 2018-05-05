<?php

namespace SwuOS\Openapi\Exception;

use Throwable;

class InvalidRequestMethodException extends CustomException
{
    public function __construct(string $message="无效的请求方式", int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}