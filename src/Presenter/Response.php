<?php


namespace LaravelApiPresenter\Presenter;


use LaravelApiPresenter\Contract\ResponseInterface;
use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;

/**
 * Class Response
 * @package LaravelApiPresenter\Presenter
 */
class Response implements ResponseInterface
{
    use MetaTrait;

    /**
     * Get response structure.
     *
     * @param ApiPresenterModel $apiPresenterModel
     *
     * @return array
     */
    public function structure(ApiPresenterModel $apiPresenterModel): array
    {
        $structure = [
            'success' => $apiPresenterModel->isSuccess(),
            'message' => $apiPresenterModel->getMessage(),
            'description' => $apiPresenterModel->getDescription(),
            'data' => $this->makeData($apiPresenterModel),
        ];

        if ($apiPresenterModel->hasMeta() && $apiPresenterModel->isAutoGenerateMeta()) {
            $meta = $this->makeMetaData($apiPresenterModel);
            $structure['links'] = $meta['links'];
            $structure['meta'] = $meta['meta'];
        } elseif ($apiPresenterModel->hasMeta()) {
            $structure['meta'] = $apiPresenterModel->getMeta()->toArray();
        }

        return $structure;
    }

    /**
     * Make main data payload.
     *
     * @param ApiPresenterModel $apiPresenterModel
     * @return array
     */
    protected function makeData(ApiPresenterModel $apiPresenterModel): array
    {
        return [
            'main_key' => $apiPresenterModel->getMainKey(),
            $apiPresenterModel->getMainKey() => $apiPresenterModel->getData(),
        ];
    }

    /**
     * Make array of response meta data.
     *
     * @param ApiPresenterModel $apiPresenterModel
     * @return array
     */
    protected function makeMetaData(ApiPresenterModel $apiPresenterModel): array
    {
        return [
            'links' => $this->links($apiPresenterModel->getMeta()),
            'meta' => $this->meta($apiPresenterModel->getMeta())
        ];
    }

}