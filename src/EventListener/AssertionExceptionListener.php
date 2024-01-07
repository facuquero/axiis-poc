<?php
namespace App\EventListener;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class AssertionExceptionListener
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof BadRequestHttpException || $exception instanceof UniqueConstraintViolationException ) {
            $errorMessage = $exception->getMessage();

            $response = new JsonResponse([
                'error' => $errorMessage,
            ], JsonResponse::HTTP_BAD_REQUEST);
            
            $event->setResponse($response);
        }
    }
}