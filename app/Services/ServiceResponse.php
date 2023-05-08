<?php

namespace App\Services;

class ServiceResponse
{

    private string $message;
    private bool $isSuccess;
    private mixed $data = [];

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ServiceResponse
     */
    public function setMessage(string $message): ServiceResponse
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @param bool $isSuccess
     * @return ServiceResponse
     */
    public function setIsSuccess(bool $isSuccess): ServiceResponse
    {
        $this->isSuccess = $isSuccess;
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
     * @return ServiceResponse
     */
    public function setData(array $data): ServiceResponse
    {
        $this->data = $data;
        return $this;
    }

}
