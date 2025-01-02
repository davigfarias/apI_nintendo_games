<?php

namespace Src\Helpers;

class Wrapper
{
    public string $status;
    public string $message;
    public mixed $data;

    public function __construct(string $status = '', string $message = '', mixed $data = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->{$name} = $value;
    }
}