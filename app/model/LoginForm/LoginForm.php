<?php

namespace app\model\LoginForm;

use app\core\helpers\StringHelper;

class LoginForm
{
    public string $userName = '';
    public string $password = '';
    public bool $rememberMe = false;

    private array $errors = [];

    public function validate(): bool
    {
        if (empty($this->userName)) {
            $this->errors[] = 'Empty user name';
        }

        $isCorrectUserName = StringHelper::isEnglishLettersText($this->userName);
        if (!$isCorrectUserName) {
            $this->errors[] = "Incorrect user name $this->userName, only english characters allowed";
        }

        if (empty($this->password)) {
            $this->errors[] = 'Empty password';
        }

        return empty($this->errors);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }


    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorsAsString(): string
    {
        return implode("\n", $this->getErrors());
    }
}
