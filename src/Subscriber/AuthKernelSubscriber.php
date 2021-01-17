<?php

namespace App\Subscriber;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class AuthKernelSubscriber implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $authorizedOrigins = array('127.0.0.1');
        $origin = $event->getRequest()->server->get('REMOTE_ADDR');

        $response = $event->getResponse();

        if(in_array($origin, $authorizedOrigins)){
            $response->headers->set('Access-Control-Allow-Origin', $event->getRequest()->server->get('HTTP_ORIGIN'));
        }else{
            $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
            $return['code'] = Response::HTTP_UNAUTHORIZED;
            $return['message'] = "You're not requesting from a known domain. If you think you are, please contact admin.";
            $response->setContent(json_encode($return));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}