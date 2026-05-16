<?php

namespace kirillbdev\WCUkrShipping\Cloud\Http;

if ( ! defined('ABSPATH')) {
    exit;
}

class CloudApiResponse
{
    private $code;
    private $data;

    public function __construct(int $code, array $data = [])
    {
        $this->code = $code;
        $this->data = $data;
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function isOk(): bool
    {
        return $this->code === 200;
    }

    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->data[ $key ] ?? $default;
    }

    public function all(): array
    {
        return $this->data;
    }
}