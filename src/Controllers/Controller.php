<?php

namespace Src\Controllers;

use Src\HTTP\Response;

class Controller 
{
    protected $response;
    
    public function __construct()
    {
        $this->response = new Response();
    }

    protected function answer($result)
    {
        try
        {
            $this->response->setContent(json_encode($result->data));
            $this->response->send();
            return;
        }
        catch(\Exception $e)
        {
            $this->response->setContent(json_encode(['error: ' => $e->getMesage()]));
            $this->response->send();
            return;
        }
    }
}