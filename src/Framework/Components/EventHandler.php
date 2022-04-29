<?php
namespace Framework\Components;

abstract class EventHandler{

    protected $context;

    abstract public function execute();

    public function setContext($context){
        $this->context = $context;
    }
}