<?php

namespace BaseFrame\System\Core;

class Router
{
    public static string $BASE_PATH;
    public static string $BASE_URL;
    public static bool $hasRoute = false;
    public static array $controller;
    public static string $url;

    private static function init(): void
    {
        require 'env.php';
        $splitURL = explode('/', $BASE_URL);
        $splitURL = array_filter($splitURL);
        $BASE_PATH = '/' . end($splitURL);
        self::$BASE_URL = $BASE_URL;
        self::$BASE_PATH = $BASE_PATH;
    }

    private static function parse_url(): string
    {
        self::init();
        $request_uri = str_replace(self::$BASE_PATH, '', $_SERVER['REQUEST_URI']);
        return $request_uri;
    }

    public static function run(string $url, string $callback, string $method = 'get'): void
    {
        $method = explode('|', strtoupper($method));
        if (in_array($_SERVER['REQUEST_METHOD'], $method)) {
            $patterns = [
                '{url}' => '([0-9a-z-A-Z=?_]+)',
                '{id}'  => '([0-9]+)'
            ];
            $url = str_replace(array_keys($patterns), array_values($patterns), $url);
            $request_uri = self::parse_url();
            if (preg_match('@^' .  $url . '$@', $request_uri, $parameters) || preg_match('@^' .  $url . '/$@', $request_uri, $parameters)) {
                self::$hasRoute = true;
                unset($parameters[0]);
                if (is_callable($callback)) {
                    call_user_func_array($callback, $parameters);
                } elseif (is_string($callback)) {
                    self::$controller = explode('@', $callback);
                    $className = explode('/', self::$controller[0]);
                    $className = end($className);
                    $folderLength = count(explode('/', self::$controller[0]));
                    $controllerFile =  self::folderDepth($folderLength);
                    if (file_exists($controllerFile)) {
                        require $controllerFile;
                        $className = 'BaseFrame\App\Controller\\' . $className;
                        call_user_func_array([new $className, self::$controller[1]], $parameters);
                    }
                }
            }
        }
    }

    private static function folderDepth(int $folderLength): string
    {
        $basePath = '/*';
        $repeatedPath = str_repeat($basePath, $folderLength);
        $controller_files = glob('app/controllers' . $repeatedPath . '.php');
        $fileLength = count(explode('/', $controller_files[0]));
        foreach ($controller_files as $file) {
            $path = '';
            $fileName =  explode('/', $file);
            for ($i = 2; $i < $fileLength; $i++) {
                $path .= $fileName[$i] . '/';
            }
            $path = rtrim($path, '/');
            if (strtolower($path) === strtolower(self::$controller[0] . '.php')) {
                self::$controller[0] = $path;
                break;
            }
        }
        $controllerFile = 'app/controllers/' . self::$controller[0];
        return $controllerFile;
    }

    public static function hasRoute(string $path, bool $activity = false): void
    {
        if (self::$hasRoute === false && $activity) {
            $url = rtrim(self::$BASE_URL, '/');
            header('Location:' . $url . '/' . $path);
        }
    }
}
