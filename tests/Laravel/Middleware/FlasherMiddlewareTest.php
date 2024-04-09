<?php

declare(strict_types=1);

namespace Flasher\Tests\Laravel\Middleware;

use Flasher\Laravel\Http\Request;
use Flasher\Laravel\Http\Response;
use Flasher\Laravel\Middleware\FlasherMiddleware;
use Flasher\Prime\Http\ResponseExtensionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class FlasherMiddlewareTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private FlasherMiddleware $middleware;
    private MockInterface&ResponseExtensionInterface $responseExtensionMock;

    protected function setUp(): void
    {
        $this->responseExtensionMock = \Mockery::mock(ResponseExtensionInterface::class);
        $this->middleware = new FlasherMiddleware($this->responseExtensionMock);
    }

    public function testHandle(): void
    {
        $laravelRequest = \Mockery::mock(LaravelRequest::class);

        $this->responseExtensionMock
            ->expects('render')
            ->with(\Mockery::type(Request::class), \Mockery::type(Response::class))
            ->andReturnUsing(function (Request $request, Response $response): Response {
                $response->setContent('Modified content');

                return $response;
            });

        /** @var LaravelResponse $response */
        $response = $this->middleware->handle($laravelRequest, fn ($r) => new LaravelResponse());
        $this->assertSame('Modified content', $response->getContent());
    }

    public function testHandleJsonResponse(): void
    {
        $laravelRequest = \Mockery::mock(LaravelRequest::class);

        $this->responseExtensionMock
            ->expects('render')
            ->with(\Mockery::type(Request::class), \Mockery::type(Response::class))
            ->andReturnUsing(function (Request $request, Response $response): Response {
                $response->setContent(json_encode(['foo' => 'modified bar'], \JSON_THROW_ON_ERROR));

                return $response;
            });

        /** @var LaravelResponse $response */
        $response = $this->middleware->handle(
            $laravelRequest,
            fn ($r) => new JsonResponse(['foo' => 'bar'])
        );

        $this->assertSame('{"foo":"modified bar"}', $response->getContent());
    }

    public function testHandleWithNonLaravelResponse(): void
    {
        $laravelRequest = \Mockery::mock(LaravelRequest::class);

        $this->responseExtensionMock->allows('render')->never();

        $response = $this->middleware->handle($laravelRequest, fn ($r) => 'Not a Laravel Response');
        $this->assertSame('Not a Laravel Response', $response);
    }
}
