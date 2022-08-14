<?php

namespace app\core\exception;

use app\core\WebRequest;
use Exception;

class AccessDeniedException extends Exception
{
    protected $code = WebRequest::CODE_ACCESS_DENIED;
}
