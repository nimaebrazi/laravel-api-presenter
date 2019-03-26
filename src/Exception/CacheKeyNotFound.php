<?php


namespace LaravelApiPresenter\Exception;


use Exception;

/**
 * Class CacheKeyNotFound
 *
 * @package LaravelApiPresenter\Exceptions
 */
class CacheKeyNotFound extends Exception
{
    protected $message = 'Not set any cache key!';
}