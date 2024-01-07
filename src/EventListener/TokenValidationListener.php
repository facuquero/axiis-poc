<?php 

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TokenValidationListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $authorizedPaths = ['/api/login', '/', '/products'];

        if (in_array($request->getPathInfo(), $authorizedPaths, true)) {
            return;
        }

        if ($this->requiresAuthentication($request)) {
            $bearerToken = $request->headers->get('Authorization');
            if (!$this->isValidToken($bearerToken)) {
                $response = new Response('Unauthorized', Response::HTTP_UNAUTHORIZED);
                $event->setResponse($response);
            }
        }
    }

    private function requiresAuthentication($request)
    {
        return true;
    }

    private function isValidToken($bearerToken)
    {
        $tokenParts = explode('=', $bearerToken, 2);
        if (count($tokenParts) === 2) {
            if ($tokenParts[1] === 'usuarioAutorizado') {
                return true; 
            }
        }
    
        return false; 
    }
}