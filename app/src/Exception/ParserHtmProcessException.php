<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

class ParserHtmProcessException extends \Exception
{
    protected $message = 'An error appeared while parsing the page. Make sure that you have processed url with chosen category like: https://rozetka.com.ua/notebooks/c80004/ or https://repka.ua/uk/products/smartfony/';

    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
