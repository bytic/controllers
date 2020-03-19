<?php

namespace Nip\Controllers\Traits;

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

    public function loadView()
    {
        echo $this->getView()->load($this->getLayoutPath());
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
        if (isset($this->getRequest()->_view) && $this->getRequest()->_view instanceof View) {
            return $this->getRequest()->_view;
        }

        $view = $this->getViewObject();
        $view = $this->populateView($view);

        $this->getRequest()->_view = $view;

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
    protected function populateView($view)
    {
        $this->populateViewPath($view);

        $view = $this->initViewVars($view);
        $view = $this->initViewContentBlocks($view);

        return $view;
    }

    /**
     * @param View $view
     */
    protected function populateViewPath($view)
    {
        if ( ! defined('MODULES_PATH')) {
            return;
        }
        $path = MODULES_PATH . $this->getRequest()->getModuleName() . '/views/';
        if ( ! is_dir($path)) {
            return;
        }
        $view->setBasePath(MODULES_PATH . $this->getRequest()->getModuleName() . '/views/');
    }

    /**
     * @param View $view
     *
     * @return View
     */
    protected function initViewVars($view)
    {
        if (method_exists($view, 'setRequest')) {
            $view->setRequest($this->getRequest());
        }

        $view->set('controller', $this->getName());
        $view->set('action', $this->getRequest()->getActionName());

        return $view;
    }

    /**
     * @param View $view
     *
     * @return View
     */
    protected function initViewContentBlocks($view)
    {
        $view->setBlock(
            'content',
            $this->getRequest()->getControllerName().'/'.$this->getRequest()->getActionName()
        );

        return $view;
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
