<?php

declare(strict_types=1);

namespace Nip\Controllers\Response\ResponseFactory;

use Nip\Http\Response\Response;
use Nip\View\View;

/**
 * Trait HasViewResponseTrait.
 */
trait HasViewResponseTrait
{
    /**
     * @var View|null
     */
    protected $view = null;

    /**
     * Create a new response for a given view.
     *
     * @param string|array $view
     * @param array        $data
     * @param int          $status
     *
     * @return Response
     */
    public function view($view, $data = [], $status = 200, array $headers = [])
    {
        return $this->make($this->renderView($view, $data), $status, $headers);
    }

    /**
     * @param string $view
     * @param array  $data
     *
     * @return bool|string|null
     */
    protected function renderView($view, $data = [])
    {
        foreach ($data as $key => $value) {
            $this->view->set($key, $value);
        }

        return $this->view->load($view, [], true);
    }

    public function setView(?View $view): void
    {
        $this->view = $view;
    }
}
