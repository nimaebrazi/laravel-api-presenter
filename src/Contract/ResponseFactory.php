<?php


namespace LaravelApiPresenter\Contract;


interface ResponseFactory
{
    /**
     * Make new response.
     *
     * @return mixed
     */
    public function make();
}