<?php

namespace Nip\Controllers\Response\ResponsePayload;

use Nip\Controllers\Response\ResponseData;

/**
 * Trait HasDataTrait
 * @package Nip\Controllers\Response\ResponsePayload
 */
trait HasDataTrait
{
    /**
     * @var ResponseData
     */
    public $data;

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return $this->data->has($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->data->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $this->data->unset($offset);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function __get(string $key)
    {
        return $this->data->get($key);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data->set($name, $value);
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->data->set($name, $value);
    }

    /**
     * @param $name
     * @param $value
     */
    public function with($key, $value = null)
    {
        $data = is_array($key) ? $key : [$key => $value];

        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->data->all();
    }

    protected function initData()
    {
        $this->data = new ResponseData();
    }
}
