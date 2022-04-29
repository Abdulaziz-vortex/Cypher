<?php
namespace App\Handlers;


use Framework\Application\Singletone;

class ProjectHandler extends \Framework\Components\EventHandler
{
    public function execute()
    {
        if(!empty($this->context)){
            Singletone::$app->redis->del($this->context);
        }
    }
}