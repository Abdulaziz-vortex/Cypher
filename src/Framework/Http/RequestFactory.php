<?php

namespace Framework\Http;

class RequestFactory
{
    public static function fromGlobals(){
        return (new Request())->withGet($_GET)->withPost($_POST);
    }
}