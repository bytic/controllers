<?php

namespace Nip\Controllers\Response\ResponseFactory;

use Nip\Http\Response\Response;
use Nip\View\View;

/**
 * Trait HasViewResponseTrait
 * @package Nip\Controllers\Response\ResponseFactory
 */
trait HasViewResponseTrait
{
    /**
     * @var null|View
     */
    protected $view = null;

    /**
     * Create a new response for a given view.
     *
     * @param string|array $view
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return Response
     */
    public function view($view, $data = [], $status = 200, array $headers = [])
    {
        return $this->make($this->renderView($view, $data), $status, $headers);
    }

    /**
     * @param string $view
     * @param array $data
     * @return bool|string|null
     */
    protected function renderView($view, $data = [])
    {
        foreach ($data as $key => $value) {
            $this->view->set($key, $value);
        }
        return $this->view->load($view, [], true);
    }

    /**
     * @param View|null $view
     */
    public function setView(?View $view): void
    {
        $this->view = $view;
    }
}
