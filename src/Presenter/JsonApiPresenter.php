<?php


namespace LaravelApiPresenter\Presenter;


use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\JsonResponse;
use LaravelApiPresenter\Contract\ApiPresenterInterface;
use LaravelApiPresenter\Contract\ResponseFactory;
use LaravelApiPresenter\Exception\CacheKeyNotFound;
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
     * @var JsonResponse
     */
    protected $jsonResponse;

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
        $this->jsonResponse = $responseFactory->make();
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
        $this->errorIfCacheKeyIsEmpty($apiPresenterModel);

        $key = $this->createCacheKey($apiPresenterModel);
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


        return $this->jsonResponse->setData($response)->setStatusCode($statusCode);
    }

    /**
     * Create cache key store data.
     *
     * @param ApiPresenterModel $apiPresenterModel
     * @return string
     */
    protected function createCacheKey(ApiPresenterModel $apiPresenterModel): string
    {
        if ($apiPresenterModel->isAutoGenerateMeta() && $apiPresenterModel->hasMeta()) {
            return $this->createCacheKeyFromMeta($apiPresenterModel);
        }

        return $apiPresenterModel->getCacheKey();
    }

    /**
     * Throw exception if cache key not exists.
     *
     * @param ApiPresenterModel $apiPresenterModel
     * @throws CacheKeyNotFound
     */
    protected function errorIfCacheKeyIsEmpty(ApiPresenterModel $apiPresenterModel): void
    {
        if (is_null($apiPresenterModel->getCacheKey())) {
            throw new CacheKeyNotFound();
        }
    }

    /**
     * Create cache key from meta data.
     *
     * @param ApiPresenterModel $apiPresenterModel
     * @return string
     */
    protected function createCacheKeyFromMeta(ApiPresenterModel $apiPresenterModel): string
    {
        $currentPage = (string)$apiPresenterModel->getMeta()['current_page'];
        $perPage = (string)$apiPresenterModel->getMeta()['per_page'];
        $key = $apiPresenterModel->getCacheKey() . "__limit_{$perPage}__page_{$currentPage}";
        return $key;
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