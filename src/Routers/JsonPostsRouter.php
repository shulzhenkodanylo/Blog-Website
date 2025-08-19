<?php

declare(strict_types=1);

namespace Task4Blog\Routers;

class JsonPostsRouter
{
    private array $routes = [];

    public function get(string $path, callable $callback): void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, callable $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve(): mixed
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'] ?? "/";
        $path = explode('?', $path)[0];

        $callback = $this->routes[$method][$path] ?? null;

        if ($callback === null) {
            http_response_code(404);
            return "404 Not Found";
        }
        if (is_array($callback)) {
            [$class, $method] = $callback;
            $controller = new $class();
            return $controller->$method();
        }
        return $callback();
    }
}
