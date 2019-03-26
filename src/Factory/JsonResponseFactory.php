<?php


namespace LaravelApiPresenter\Factory;


use Illuminate\Http\JsonResponse;

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