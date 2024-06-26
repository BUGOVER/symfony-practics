<?php

declare(strict_types=1);

namespace App\Tests\Listener;

use App\Listener\ApiExceptionListener;
use App\Model\Details\ErrorDebugDetails;
use App\Model\ErrorResponse;
use App\Resolver\ExceptionMappingResolver;
use App\Service\ExceptionMapping;
use App\Tests\AbstractCaseTest;
use InvalidArgumentException;
use JsonException;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @link ApiExceptionListener
 */
class ApiExceptionListenerTest extends AbstractCaseTest
{
    private LoggerInterface $logger;

    private SerializerInterface $serializer;

    private ExceptionMappingResolver $resolver;

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testNon500MappingWithMessage(): void
    {
        $mapping = ExceptionMapping::fromCode(Response::HTTP_NOT_FOUND);
        $response_message = Response::$statusTexts[$mapping->getCode()];
        $response_body = json_encode(['error' => $response_message], JSON_THROW_ON_ERROR);

        $this->resolver
            ->expects(self::once())
            ->method('resolve')
            ->with(InvalidArgumentException::class)
            ->willReturn($mapping);

        $this->serializer
            ->method('serialize')
            ->with($this->callback(function (ErrorResponse $response) use ($response_message) {
                return $response->getMessage() == $response_message
                    && $response->getDetails() instanceof ErrorDebugDetails
                    && !empty($response->getDetails()->getTrace());
            }), JsonEncoder::FORMAT)
            ->willReturn($response_body);

        $response = $this->sendEvent();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertJsonStringEqualsJsonString($response_body, $response->getContent());
    }

    /**
     * @return Response|null
     */
    private function sendEvent(): ?Response
    {
        $event = $this->createEvent(new InvalidArgumentException('test'));
        $listener = new ApiExceptionListener($this->resolver, $this->logger, $this->serializer, true);
        $listener($event);

        return $event->getResponse();
    }

    /**
     * @param InvalidArgumentException $exception
     * @return ExceptionEvent
     */
    private function createEvent(InvalidArgumentException $exception): ExceptionEvent
    {
        return new ExceptionEvent(
            $this->createTestKernel(),
            new Request(),
            HttpKernelInterface::MAIN_REQUEST,
            $exception
        );
    }

    /**
     * @return HttpKernelInterface
     */
    private function createTestKernel(): HttpKernelInterface
    {
        return new class () implements HttpKernelInterface {
            /**
             * @param Request $request
             * @param int $type
             * @param bool $catch
             * @return Response
             */
            public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
            {
                return new Response('test');
            }
        };
    }

    /**
     * @throws JsonException
     */
    public function testNon500MappingMessage(): void
    {
        $mapping = new ExceptionMapping(Response::HTTP_NOT_FOUND, false, false);
        $response_message = 'test';
        $response_body = json_encode(['error' => $response_message], JSON_THROW_ON_ERROR);

        $this->resolver
            ->expects(self::once())
            ->method('resolve')
            ->with(InvalidArgumentException::class)
            ->willReturn($mapping);

        $this->serializer
            ->method('serialize')
            ->with($this->callback(function (ErrorResponse $response) use ($response_message) {
                return $response->getMessage() === $response_message
                    && $response->getDetails() instanceof ErrorDebugDetails
                    && !empty($response->getDetails()->getTrace());
            }), JsonEncoder::FORMAT)
            ->willReturn($response_body);

        $response = $this->sendEvent();

        self::assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertJsonStringEqualsJsonString($response_body, $response->getContent());
    }

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->resolver = $this->createMock(ExceptionMappingResolver::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
    }
}
