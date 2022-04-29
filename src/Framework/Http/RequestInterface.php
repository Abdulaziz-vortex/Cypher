<?php

namespace Framework\Http;

interface RequestInterface {
    public function getParsedBody();
    public function getGet();
    public function getPost();
}