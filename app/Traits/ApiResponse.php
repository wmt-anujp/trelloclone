<?php

namespace App\Traits;

trait ApiResponse
{
    protected $meta;
    protected $response;
    protected $data;

    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }

    public function setData($key, $value)
    {
        $this->data[$key] = $value;
        return $this->data;
    }

    public function customResponse($status, $message, $statusCode)
    {
        $this->setMeta('status', $status);
        $this->setMeta('message', $message);
        $this->setMeta('code', $statusCode);
        return $this->meta;
    }

    public function setResponse()
    {
        $this->response['meta'] = $this->meta;
        if ($this->data !== null) {
            $this->response['data'] = $this->data;
        }
        $this->meta = array();
        $this->data = array();
        return $this->response;
    }
}
