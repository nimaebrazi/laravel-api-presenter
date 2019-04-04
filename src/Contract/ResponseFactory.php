<?php


namespace LaravelApiPresenter\Contract;


/**
 * Interface ResponseFactory
 * @package LaravelApiPresenter\Contract
 */
interface ResponseFactory
{
    /**
     * Make new response.
     *
     * @return mixed
     */
    public function make();
}