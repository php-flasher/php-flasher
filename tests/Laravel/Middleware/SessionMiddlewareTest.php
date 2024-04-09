<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Middleware;

use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Laravel\Middleware\SessionMiddleware;
use Flasher\Prime\Http\RequestExtensionInterface;
use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * This TestCase is designed to test handle method of SessionMiddleware
 * which wraps the given request into a Flasher Request and Flasher Response,
 * and attaches them into Extension.
 */
final class SessionMiddlewareTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private MockInterface&RequestExtensionInterface $requestExtensionMock;

    private SessionMiddleware $sessionMiddleware;

    protected function setUp(): void
    {
        $this->requestExtensionMock = \Mockery::mock(RequestExtensionInterface::class);
        $this->sessionMiddleware = new SessionMiddleware($this->requestExtensionMock);
    }

    public function testHandleWithLaravelResponse(): void
    {
        $requestMock = \Mockery::mock(LaravelRequest::class);
        $responseMock = \Mockery::mock(LaravelResponse::class);

        $this->requestExtensionMock->expects('flash')
            ->withArgs(function ($flasherRequest, $flasherResponse) {
                return $flasherRequest instanceof Request && $flasherResponse instanceof Response;
            });

        $handle = $this->sessionMiddleware->handle($requestMock, fn () => $responseMock);

        $this->assertSame($responseMock, $handle);
    }

    public function testHandleWithLaravelJsonResponse(): void
    {
        $requestMock = \Mockery::mock(LaravelRequest::class);
        $responseMock = \Mockery::mock(LaravelJsonResponse::class);

        $this->requestExtensionMock->expects('flash')
            ->withArgs(function ($flasherRequest, $flasherResponse) {
                return $flasherRequest instanceof Request && $flasherResponse instanceof Response;
            });

        $handle = $this->sessionMiddleware->handle($requestMock, fn () => $responseMock);

        $this->assertSame($responseMock, $handle);
    }

    public function testHandleWithOtherResponses(): void
    {
        $requestMock = \Mockery::mock(LaravelRequest::class);
        $responseMock = \Mockery::mock(\Symfony\Component\HttpFoundation\Response::class);

        $this->requestExtensionMock->allows('flash')->never();

        $handle = $this->sessionMiddleware->handle($requestMock, fn () => $responseMock);

        $this->assertSame($responseMock, $handle);
    }
}
