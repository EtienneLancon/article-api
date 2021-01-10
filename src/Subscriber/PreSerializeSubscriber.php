<?php

namespace App\Subscriber;

use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\SerializationContext;

class PreSerializeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::PRE_SERIALIZE,
                'class' => 'Article',
                'format' => 'json',
                'method' => 'modifyGroups',
            ],
            [
                'event' => Events::POST_SERIALIZE,
                'method' => 'plop',
            ]
        ];
    }

    public static function modifyGroups(PreSerializeEvent $event)
    {
        $event->getContext()->setGroups(['list']);
    }

    public static function plop(ObjectEvent $event)
    {
        
    }
}