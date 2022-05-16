<?php

namespace App\Handlers;

use Framework\Components\EventHandler;

class NotifyHandler extends EventHandler
{

    public function execute()
    {
        return $this->alert('item added'.' '. $this->context['value']);
    }

    public function alert($msg){
        $result = <<<TXT
            <script>
                alert('"$msg"');
            </script>  
        TXT;
        echo $result;
    }

}