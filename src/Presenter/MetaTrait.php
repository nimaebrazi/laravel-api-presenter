<?php


namespace LaravelApiPresenter\Presenter;


trait MetaTrait
{
    /**
     * Make meta data.
     *
     * @param array $meta
     * @return array
     */
    protected function meta(array $meta): array
    {
        return [
            'current_page' => $meta['current_page'],
            'from' => $meta['from'],
            'last_page' => $meta['last_page'],
            'path' => $meta['path'],
            'per_page' => $meta['per_page'],
            'to' => $meta['to'],
            'total' => $meta['total']
        ];
    }

    /**
     * Make links.
     *
     * @param array $links
     * @return array
     */
    protected function links(array $links)
    {
        return [
            'first' => $links['first_page_url'],
            'last' => $links['last_page_url'],
            'next' => $links['next_page_url'],
            'prev' => $links['prev_page_url'],
        ];
    }

}