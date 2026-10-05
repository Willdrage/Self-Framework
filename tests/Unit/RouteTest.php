<?php
namespace Tests\Unit;

use App\Core\Route;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class RouteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (new ReflectionProperty(Route::class, 'routes'))->setValue(null, []);
        http_response_code(200);
    }

    public function testDispatchesGetPostAndPutRoutes(): void
    {
        Route::get('/items', [RouterTestController::class, 'index']);
        Route::post('/items', [RouterTestController::class, 'store']);
        Route::put('/items', [RouterTestController::class, 'update']);

        $router = new Route();

        self::assertSame('index', $router->getRoute('/items', 'GET'));
        self::assertSame('store', $router->getRoute('/items', 'POST'));
        self::assertSame('update', $router->getRoute('/items', 'PUT'));
    }

    public function testPassesRouteParametersToControllerAction(): void
    {
        Route::get('/items/{id}', [RouterTestController::class, 'show']);

        $result = (new Route())->getRoute('/items/42', 'GET');

        self::assertSame('42', $result);
    }

    public function testBindsRouteIdToModelTypedControllerParameter(): void
    {
        Route::get('/items/{item}', [RouterModelBindingTestController::class, 'show']);

        $result = (new Route())->getRoute('/items/73', 'GET');

        self::assertSame(73, RouterTestItemModel::$foundId);
        self::assertSame(73, $result);
    }

    public function testReturnsNotFoundForUnknownRouteOrMethod(): void
    {
        Route::get('/items', [RouterTestController::class, 'index']);
        $router = new Route();

        $router->getRoute('/missing', 'GET');
        self::assertSame(404, http_response_code());

        http_response_code(200);
        $router->getRoute('/items', 'DELETE');
        self::assertSame(404, http_response_code());
    }
}

class RouterTestController
{
    public function index(): string
    {
        return 'index';
    }

    public function store(): string
    {
        return 'store';
    }

    public function update(): string
    {
        return 'update';
    }

    public function show(string $id): string
    {
        return $id;
    }
}

class RouterModelBindingTestController
{
    public function show(RouterTestItemModel $item): int
    {
        return $item->id;
    }
}

class RouterTestItemModel
{
    public static ?int $foundId = null;
    public int $id;

    public function __construct()
    {
    }

    public function find(int $id): ?object
    {
        self::$foundId = $id;
        $item = new self();
        $item->id = $id;

        return $item;
    }
}