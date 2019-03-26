<?php


namespace LaravelApiPresenter\Exception;


use Exception;

/**
 * Class NotFoundPresenterException
 * @package App\Infrastructure\ApiPresenter\Exceptions
 */
class NotFoundPresenterException extends Exception
{
    protected $message = 'Not found api presenter implementation!';
}