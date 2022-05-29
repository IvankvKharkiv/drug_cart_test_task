<?php

namespace App\Exception;

use Throwable;

class InvalidWebParserException extends \Exception
{
    protected $message = 'Invalid Web Parser Parameter Type.';

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}