<?php

namespace Notes\Response;

class Response
{
    public function __construct($code, $status, $data)
    {
        if ($status = "success") {
            $this->to_JSON($data);
        } else {
            $this->ErrorMessage();
        }
        
    }
    public function ErrorMessage()
    {
        
    }
    public function to_JSON()
    {
        
    }    
}
