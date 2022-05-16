<?php

namespace Framework\Components;

class Pubsub
{
    public array $events = [];

    public function publish(string $event_name, $context = null): void
    {
        if (!empty($this->events[$event_name]) && array_key_exists($event_name, $this->events)) {
            /**
             * @var $obj EventHandler
             */
            foreach ($this->events[$event_name] as $obj) {
                if ($context !== null) {
                    $obj->setContext($context);
                }
                $obj->execute();
            }
        }
    }

    public function subscribe(string $event_name, EventHandler $handler)
    {
        $this->setEvent($event_name, $handler);

    }

    public function getEvents()
    {
        return $this->events;
    }

    public function setEvent(string $event_name, ?EventHandler $handler = null): void
    {

        if (empty($event_name)) {
            throw new \Exception('evant name can\'t be empty');
        }


        if (!array_key_exists($event_name, $this->events)) {
            if ($handler !== null) {
                $this->events[$event_name] = [$handler];
            } else {
                $this->events[$event_name] = [];
            }
        } else {
            $this->events[$event_name][] = $handler;
        }

    }

}