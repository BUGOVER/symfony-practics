<?php

declare(strict_types=1);

namespace App\Tests\Resolver;

use App\Attributes\RequestBody;
use App\Exception\RequestBodyConvertException;
use App\Exception\ValidationException;
use App\Resolver\RequestArgumentResolver;
use App\Tests\AbstractCaseTest;
use Exception;
use JsonException;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @runTestsInSeparateProcesses
 */
class RequestArgumentResolverTest extends AbstractCaseTest
{
    private SerializerInterface $serializer;

    private ValidatorInterface $validator;

    /**
     * @return void
     * @preserveGlobalState disabled
     */
    public function testResolveExceptionDeserialize(): void
    {
        $this->expectException(RequestBodyConvertException::class);

        $this->serializer
            ->method('deserialize')
            ->with('content', stdClass::class, JsonEncoder::FORMAT)
            ->willThrowException(new Exception('fake content'));

        $this->callResolver();
    }

    /**
     * @param string|array $content
     * @param bool $request_body
     * @return iterable
     */
    private function callResolver(string|array $content = '', bool $request_body = true): iterable
    {
        $argument = new ArgumentMetadata(
            'test',
            stdClass::class,
            false,
            false,
            null,
            false,
            $request_body ? [new RequestBody()] : []
        );

        return (new RequestArgumentResolver($this->serializer, $this->validator))
            ->resolve(new Request(content: $content), $argument);
    }

    /**
     * @return void
     * @throws JsonException
     * @preserveGlobalState disabled
     */
    public function testResolveExceptionvalidate(): void
    {
        $this->expectException(ValidationException::class);

        $body = ['test' => true];
        $encode_body = json_encode($body, JSON_THROW_ON_ERROR);

        $this->serializer
            ->method('deserialize')
            ->with($encode_body, stdClass::class, JsonEncoder::FORMAT)
            ->willReturn($body);

        $this->validator->method('validate')
            ->willReturn(new ConstraintViolationList(
                new ConstraintViolationList([
                    new ConstraintViolation('error', null, [], null, null, null)
                ])
            ));

        $this->callResolver($encode_body);
    }

    /**
     * @return void
     */
    public function testResolveRequestBodyNonInstanceOf(): void
    {
        $result = $this->callResolver(request_body: false);

        self::assertIsArray($result);
        self::assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testResolveSuccess(): void
    {
        $result = $this->callResolver();

        self::assertIsArray($result);
        self::assertNotEmpty($result);
    }

    /**
     * @return void
     * @throws Exception|\PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
    }
}
