<?php
return [
    'components' => [
        'pubsub' => \Framework\Components\Pubsub::class,
        'redis' => \Predis\Client::class,
        //'request' => \Framework\Http\Request::class,
    ]
];