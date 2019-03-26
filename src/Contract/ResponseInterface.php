<?php


namespace LaravelApiPresenter\Contract;


use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;

/**
 * Interface ResponseInterface
 * @package LaravelApiPresenter\Contract
 */
interface ResponseInterface
{
    /**
     * Get response structure.
     *
     * @param ApiPresenterModel $apiPresenterModel
     *
     * @return array
     */
    public function structure(ApiPresenterModel $apiPresenterModel): array;
}