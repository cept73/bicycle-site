<?php

namespace app\core\exception;

use app\core\WebRequest;
use Exception;

class WrongConfigurationException extends Exception
{
    protected $code = WebRequest::CODE_FATAL;
}
