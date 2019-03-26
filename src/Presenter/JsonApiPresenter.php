<?php


namespace LaravelApiPresenter\Presenter;


use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\JsonResponse;
use LaravelApiPresenter\Contract\ApiPresenterInterface;
use LaravelApiPresenter\Exception\CacheKeyNotFound;
use LaravelApiPresenter\Factory\ResponseFactory;
use LaravelApiPresenter\Presenter\Model\ApiPresenterModel;

/**
 * Class JsonApiPresenter
 * @package App\Infrastructure\ApiPresenter
 */
class JsonApiPresenter implements ApiPresenterInterface
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var ResponseFactory
     */
    protected $responseFactory;

    /**
     * @var CacheRepository
     */
    protected $cacheRepository;


    /**
     * JsonApiPresenter constructor.
     *
     * @param Response $response
     * @param ResponseFactory $responseFactory
     * @param CacheRepository $cacheRepository
     */
    public function __construct(Response $response, ResponseFactory $responseFactory, CacheRepository $cacheRepository)
    {
        $this->response = $response;
        $this->responseFactory = $responseFactory;
        $this->cacheRepository = $cacheRepository;
    }

    /**
     * Present data to client.
     *
     * @param ApiPresenterModel $apiPresenterModel
     *
     * @throws CacheKeyNotFound
     *
     * @return mixed
     */
    public function present(ApiPresenterModel $apiPresenterModel)
    {
        if ($apiPresenterModel->isCacheable()) {
            return $this->prepareWithCache($apiPresenterModel);
        }

        return $this->prepareWithoutCache($apiPresenterModel);
    }

    /**
     * Present data to client from cache.
     *
     * @param ApiPresenterModel $apiPresenterModel
     *
     * @throws CacheKeyNotFound
     *
     * @return mixed
     */
    protected function prepareWithCache(ApiPresenterModel $apiPresenterModel)
    {
        $key = $apiPresenterModel->getCacheKey();

        if (is_null($key)) {
            throw new CacheKeyNotFound();
        }

        if ($apiPresenterModel->isCacheable() && $apiPresenterModel->isAutoGenerateMeta()) {
            $currentPage = (string)$apiPresenterModel->getMeta()['current_page'];
            $perPage = (string)$apiPresenterModel->getMeta()['per_page'];
            $key = $apiPresenterModel->getCacheKey() . "__limit_{$perPage}__page_{$currentPage}";
        }

        $ttl = $apiPresenterModel->getCacheTTL();

        return $this->cacheRepository->remember($key, $ttl, function () use ($apiPresenterModel) {
            return $this->prepareWithoutCache($apiPresenterModel);
        });

    }

    /**
     * Present data to client.
     *
     * @param ApiPresenterModel $apiPresenterModel
     *
     * @return mixed
     */
    protected function prepareWithoutCache(ApiPresenterModel $apiPresenterModel)
    {
        $response = $this->response->structure($apiPresenterModel);
        $statusCode = $apiPresenterModel->getStatusCode();

        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->responseFactory->make();

        return $jsonResponse->setData($response)->setStatusCode($statusCode);
    }

    /**
     * Get response model.
     *
     * @return JsonResponse
     */
    public function response()
    {
        return $this->jsonResponse;
    }

}