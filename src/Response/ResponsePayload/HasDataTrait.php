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

    protected function initData()
    {
        $this->data = new ResponseData();
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
     * @return mixed
     */
    public function all()
    {
        return $this->data->all();
    }
}