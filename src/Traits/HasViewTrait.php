<?php

declare(strict_types=1);

namespace Nip\Controllers\Traits;

use Nip\Controllers\View\ControllerViewHydrator;
use Nip\Http\Request;
use Nip\View;

/**
 * Trait HasViewTrait
 * @package Nip\Controllers\Traits
 */
trait HasViewTrait
{
    use AbstractControllerTrait;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var string
     */
    protected $layout = 'default';

    /**
     * @param bool $return
     * @return bool|string|null
     */
    public function loadView($return = false)
    {
        $view = $this->getView();
        $this->populateView($view);
        $content = $view->load($this->getLayoutPath());
        if ($return == true) {
            return $content;
        }
        echo $content;
        return null;
    }

    /**
     * @return View
     */
    public function getView()
    {
        if (!$this->view) {
            $this->view = $this->initView();
        }

        return $this->view;
    }

    /**
     * @param View $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * @return View
     */
    protected function initView()
    {
        $request = $this->getRequest();
        if ($request instanceof Request) {
            if (isset($request->_view) && $request->_view instanceof View) {
                return $request->_view;
            }
        }

        $view = $this->getViewObject();

        if ($request instanceof Request) {
            $request->_view = $view;
        }

        return $view;
    }

    /**
     * @return View
     */
    protected function getViewObject()
    {
        return new View();
    }

    /**
     * @param View $view
     *
     * @return View
     */
    public function populateView($view)
    {
        $this->populateViewPath($view);

        $view = $this->initViewVars($view);

        // @deprecated Rely on Response Payload Transformer to call this method
//        $view = $this->initViewContentBlocks($view);

        return $view;
    }

    public function registerViewPaths(View\View $view): void
    {
    }

    /**
     * @deprecated Rely on Response Payload Transformer to call this method. Use RegisterViewPaths if necessary
     */
    protected function populateViewPath($view)
    {
        return ControllerViewHydrator::populatePath($view, $this);
    }

    /**
     * @param View $view
     *
     * @return View
     */
    protected function initViewVars($view)
    {
        return ControllerViewHydrator::initVars($view, $this);
    }

    /**
     * @param View $view
     *
     * @return View
     */
    protected function initViewContentBlocks($view)
    {
        return ControllerViewHydrator::initContentBlocks($view, $this);
    }

    /**
     * @return string
     */
    public function getLayoutPath()
    {
        return '/layouts/' . $this->getLayout();
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}
