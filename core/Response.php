<?php

namespace app\core;

class Response
{
    public function setStatucCode($code)
    {
        http_response_code($code);
    }
}