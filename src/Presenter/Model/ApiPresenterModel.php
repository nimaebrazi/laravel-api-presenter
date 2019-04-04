<?php


namespace LaravelApiPresenter\Presenter\Model;


use Illuminate\Contracts\Support\Arrayable;

/**
 * Class ApiPresenterModel
 * @package LaravelApiPresenter\Presenter\Model
 */
class ApiPresenterModel
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var string
     */
    protected $mainKey;

    /**
     * @var array|Arrayable
     */
    protected $meta = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var bool
     */
    protected $autoGenerateMeta = false;

    /**
     * @var bool
     */
    protected $cacheable = false;

    /**
     * @var int
     */
    protected $cacheTTL= 240;

    /**
     * @var string|null
     */
    protected $cacheKey = null;


    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ApiPresenterModel
     */
    public function setDescription(string $description): ApiPresenterModel
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return ApiPresenterModel
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMainKey(): string
    {
        return $this->mainKey;
    }

    /**
     * @param string $mainKey
     * @return ApiPresenterModel
     */
    public function setMainKey(string $mainKey): self
    {
        $this->mainKey = $mainKey;

        return $this;
    }

    /**
     * @return array|Arrayable
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param array|Arrayable $meta
     * @return ApiPresenterModel
     */
    public function setMeta($meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return ApiPresenterModel
     */
    public function setData(array $data): self
    {
        if (array_key_exists('data', $data)) {

            $this->data = $data['data'];
            $this->createMeta($data);

        } else {
            $this->data = $data;
        }


        return $this;
    }

    /**
     * @param array $data
     */
    public function createMeta(array $data)
    {
        if ($this->autoGenerateMeta && !$this->hasMeta() && $this->hasData()) {
            unset($data['data']);
            $this->meta = $data;
        }
    }

    /**
     * @return bool
     */
    public function hasMeta(): bool
    {
        if ($this->meta instanceof Arrayable){
            return !empty($this->meta->toArray());
        }

        return !empty($this->meta);
    }

    /**
     * @return bool
     */
    public function hasData(): bool
    {
        return !empty($this->data);
    }

    /**
     * Change status to success.
     */
    public function withSuccessStatus()
    {
        $this->success = true;

        return $this;
    }

    /**
     * Change status to error.
     */
    public function withErrorStatus()
    {
        $this->success = false;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ApiPresenterModel
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return ApiPresenterModel
     */
    public function withMeta(): self
    {
        $this->autoGenerateMeta = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCacheable(): bool
    {
        return $this->cacheable;
    }

    /**
     * @return ApiPresenterModel
     */
    public function cacheable(): self
    {
        $this->cacheable = true;

        return $this;
    }

    /**
     * @return int
     */
    public function getCacheTTL(): int
    {
        return $this->cacheTTL;
    }

    /**
     * @param int $cacheTTL
     * @return ApiPresenterModel
     */
    public function setCacheTTL(int $cacheTTL): ApiPresenterModel
    {
        $this->cacheTTL = $cacheTTL;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCacheKey(): ?string
    {
        return $this->cacheKey;
    }

    /**
     * @param null|string $cacheKey
     * @return ApiPresenterModel
     */
    public function setCacheKey(?string $cacheKey): self
    {
        $this->cacheKey = $cacheKey;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoGenerateMeta(): bool
    {
        return $this->autoGenerateMeta;
    }

}