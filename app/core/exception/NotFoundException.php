<?php

namespace app\core\exception;

use app\core\WebRequest;
use Exception;

class NotFoundException extends Exception
{
    protected $code = WebRequest::CODE_NOT_FOUND;
}
