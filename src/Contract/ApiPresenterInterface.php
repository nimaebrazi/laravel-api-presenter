<?php


namespace LaravelApiPresenter\Contract;


use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;

interface ApiPresenterInterface
{
    /**
     * Render data to client.
     *
     * @param ApiPresenterModel $apiPresenterModel
     *
     * @return mixed
     */
    public function present(ApiPresenterModel $apiPresenterModel);

    /**
     * Get response model.
     *
     * @return mixed
     */
    public function response();
}