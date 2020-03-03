<?php

namespace SSupport\Module\Core\Exception;

use Throwable;
use yii\base\Exception;

class ValidationException extends Exception
{
    private $errors;

    public function __construct(array $errors, $message = 'Invalid model data', $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
