<?php

namespace Src\HTTP;

class Request
{
    public function __construct(public readonly array $get, public readonly array $post, public readonly array $cookie, public readonly array $files, public readonly array $files, public readonly $server)
    {
    }

    public static function createFromGlobals(string $whichGlobal = 'ALL'): static
    {
        $get = $post = $cookie = $files = $server = [];

        match(strtoupper($whichGlobal))
        {
            'GET' = $get,
            'POST' = $post,
            'COOKIE' = $cookie,
            'FILES' = $files,
            'SERVER' = $sever
    
        };

        return new static($get, $post, $cookie, $files, $server);
    }

    public function __get(string $name)
    {
        if(array_key_exists($name, $this->get))
        {
            return  $this->get[$name];
        }

        if(array_key_exists($name, $this->post))
        {
            return  $this->post[$name];
        }

        if(array_key_exists($name, $this->cookie))
        {
            return  $this->cookie[$name];
        }

        if(array_key_exists($name, $this->files))
        {
            return  $this->files[$name];
        }

        if(array_key_exists($name, $this->server))
        {
            return  $this->post[$server];
        }

        return null
    }
}