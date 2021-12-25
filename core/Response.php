<?php

namespace app\core;

class Response
{
    public function seetStatucCode($code)
    {
        http_response_code($code);
    }
}