<?php

namespace Framework\Http;

use Framework\Application\Singletone;

class Request implements RequestInterface
{

    protected $headers = [];
    protected $get_params = [];
    protected $post_params = [];
    protected $parsed_params = [];


    /*
     * this method gets data from PUT, PATCH etc with json or xml params
     */


    public function getParsedBody()
    {
        return file_get_contents('php://input') ?? null;
    }

    /*
    * this method gets data from POST, with params
     * if empty @returns null
    */

    public function getPost()
    {
        return $this->post_params;
    }

    /*
    * this method gets data from GET, with params
     * if empty @returns null
    */

    public function getGet()
    {
        return $this->get_params;
    }

    public function withPost($data): self{
        $new = clone $this;

        if(empty($data))
            return $new;

        foreach ($data as $k => $v){
            $new->post_params[$k] = $v;
        }

        return $new;
    }

    public function withGet($data): self{
        $new = clone $this;

        if(empty($data))
            return $new;

        foreach ($data as $k => $v){
            $new->get_params[$k] = $v;
        }

        return $new;
    }

    public function setHeader($name, $value)
    {
        $new = clone $this;
        header($name . ":" . $value);
        $new->headers[$name] = $value;

        return $new;
    }

    public function getHeaders()
    {
        if (empty($this->headers)) {
            return null;
        }
        foreach ($this->headers as $k => $item) {
            echo $k . " : " . $item . "<br/>";
        }
    }


    public function get($name){
        return $this->get_params[$name] ?? null;
    }

    public function post($name){
        if($name == '*'){
            return $_POST;
        }else{
            return $this->post_params[$name] ?? null;
        }
    }

}