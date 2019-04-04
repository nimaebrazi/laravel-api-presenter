<?php


namespace LaravelApiPresenter\Factory;


use Illuminate\Http\JsonResponse;
use LaravelApiPresenter\Contract\ResponseFactory;

/**
 * Class JsonResponseFactory
 * @package LaravelApiPresenter\Factory
 */
class JsonResponseFactory implements ResponseFactory
{

    /**
     * Make new response.
     *
     * @return JsonResponse
     */
    public function make()
    {
        return new JsonResponse();
    }
}