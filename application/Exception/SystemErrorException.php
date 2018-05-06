<?php

namespace SwuOS\Openapi\Exception;


use Throwable;

class SystemErrorException extends CustomException
{
    public function __construct(string $message = "服务器错误", int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}