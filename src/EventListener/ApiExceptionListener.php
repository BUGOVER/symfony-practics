<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Model\ErrorResponse;
use App\Service\ExceptionHandler\ExceptionMapping;
use App\Service\ExceptionHandler\ExceptionMappingResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

use function get_class;

class ApiExceptionListener
{
    /**
     * @param ExceptionMappingResolver $resolver
     * @param LoggerInterface $logger
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private readonly ExceptionMappingResolver $resolver,
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @param ExceptionEvent $event
     * @return void
     */
    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $mapping = $this->resolver->resolve(get_class($throwable));

        if (null === $mapping) {
            $mapping = ExceptionMapping::fromCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (Response::HTTP_INTERNAL_SERVER_ERROR < $mapping->getCode() || $mapping->isLoggable()) {
            $this->logger->error($throwable->getMessage(), [
                'trace' => $throwable->getTraceAsString(),
                'previous' => $throwable->getPrevious() ? $throwable->getPrevious()->getMessage() : '',
            ]);
        }

        $message = $mapping->isHidden() ? Response::$statusTexts[$mapping->getCode()] : $throwable->getMessage();
        $data = $this->serializer->serialize(new ErrorResponse($message), JsonEncoder::FORMAT);
        $response = new JsonResponse($data, $throwable->getCode(), [], true);

        $event->setResponse($response);
    }
}