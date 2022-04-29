<?php

namespace App\Handlers;

use Framework\Application\Singletone;
use Framework\Components\EventHandler;

class FormHandler extends EventHandler
{
    public string $key;
    public string $value;

    public function execute()
    {
        $this->key = $this->context['key'] ?? null;
        $this->value = $this->context['value'] ?? null;

        if(($this->key != null) && ($this->value != null)){
            Singletone::$app->redis->set($this->key,$this->value);
        }
    }
}