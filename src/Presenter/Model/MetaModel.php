<?php


namespace LaravelApiPresenter\Presenter\Model;


use Illuminate\Contracts\Support\Arrayable;
use LaravelApiPresenter\Util\ReflectionHelper;

/**
 * Class MetaModel
 * @package LaravelApiPresenter\Presenter\Model
 */
class MetaModel implements Arrayable
{
    /**
     * @var int|null
     */
    protected $currentPage;

    /**
     * @var string|null
     */
    protected $firstPageUrl;

    /**
     * @var int|null
     */
    protected $from;

    /**
     * @var int|null
     */
    protected $lastPage;

    /**
     * @var string|null
     */
    protected $lastPageUrl;

    /**
     * @var string|null
     */
    protected $nextPageUrl;

    /**
     * @var string|null
     */
    protected $path;

    /**
     * @var string|null
     */
    protected $perPage;

    /**
     * @var null|string
     */
    protected $prevPageUrl = null;

    /**
     * @var int|null
     */
    protected $to;

    /**
     * @var int|null
     */
    protected $total;

    /**
     * @return int|null
     */
    public function getCurrentPage(): ?int
    {
        return $this->currentPage;
    }

    /**
     * @param int|null $currentPage
     * @return MetaModel
     */
    public function setCurrentPage(?int $currentPage): MetaModel
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstPageUrl(): ?string
    {
        return $this->firstPageUrl;
    }

    /**
     * @param null|string $firstPageUrl
     * @return MetaModel
     */
    public function setFirstPageUrl(?string $firstPageUrl): MetaModel
    {
        $this->firstPageUrl = $firstPageUrl;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFrom(): ?int
    {
        return $this->from;
    }

    /**
     * @param int|null $from
     * @return MetaModel
     */
    public function setFrom(?int $from): MetaModel
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLastPage(): ?int
    {
        return $this->lastPage;
    }

    /**
     * @param int|null $lastPage
     * @return MetaModel
     */
    public function setLastPage(?int $lastPage): MetaModel
    {
        $this->lastPage = $lastPage;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastPageUrl(): ?string
    {
        return $this->lastPageUrl;
    }

    /**
     * @param null|string $lastPageUrl
     * @return MetaModel
     */
    public function setLastPageUrl(?string $lastPageUrl): MetaModel
    {
        $this->lastPageUrl = $lastPageUrl;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getNextPageUrl(): ?string
    {
        return $this->nextPageUrl;
    }

    /**
     * @param null|string $nextPageUrl
     * @return MetaModel
     */
    public function setNextPageUrl(?string $nextPageUrl): MetaModel
    {
        $this->nextPageUrl = $nextPageUrl;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param null|string $path
     * @return MetaModel
     */
    public function setPath(?string $path): MetaModel
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPerPage(): ?string
    {
        return $this->perPage;
    }

    /**
     * @param null|string $perPage
     * @return MetaModel
     */
    public function setPerPage(?string $perPage): MetaModel
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrevPageUrl(): ?string
    {
        return $this->prevPageUrl;
    }

    /**
     * @param null|string $prevPageUrl
     * @return MetaModel
     */
    public function setPrevPageUrl(?string $prevPageUrl): MetaModel
    {
        $this->prevPageUrl = $prevPageUrl;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTo(): ?int
    {
        return $this->to;
    }

    /**
     * @param int|null $to
     * @return MetaModel
     */
    public function setTo(?int $to): MetaModel
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * @param int|null $total
     * @return MetaModel
     */
    public function setTotal(?int $total): MetaModel
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return ReflectionHelper::getProProperties($this);
    }
}