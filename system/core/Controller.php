<?php

namespace BaseFrame\System\Core;

class Controller
{
    protected string $BASE_URL;

    public function __construct()
    {
        require 'env.php';
        $this->BASE_URL = $BASE_URL;
    }

    protected function view(string $viewFile, array $data = []): void
    {
        /*   $data = [
             'name'    => 'ozgur',
             'surname' => 'vurgun'
             ];
        */
        extract($data);
        /*  echo $name;
            echo $surname;
        */
        require 'env.php';
        $fileName = $this->viewFolderDepth($viewFile);
        require_once 'app/views/' . $fileName;
    }

    protected function model(string $modelFile)
    {
        $fileName = $this->modelFolderDepth($modelFile);
        require_once 'app/models/' . $fileName;
        $modelFile =  explode('/', $modelFile);
        $className = 'BaseFrame\App\Model\\' . end($modelFile);
        return new $className();
    }

    private function viewFolderDepth(string $name): string
    {
        $folderLength =  count(explode('/', $name));
        $basePath = '/*';
        $repeatedPath = str_repeat($basePath, $folderLength);
        $view_files = glob('app/views' . $repeatedPath . '.php');
        $fileLength = count(explode('/', $view_files[0]));

        foreach ($view_files as $file) {
            $path = '';
            $fileName =  explode('/', $file);
            for ($i = 2; $i < $fileLength; $i++) {
                $path .= $fileName[$i] . '/';
            }
            $path = rtrim($path, '/');
            if (strtolower($path) === strtolower($name . '.php')) {
                $fileName = $path;
                break;
            }
        }
        return $fileName;
    }

    private function modelFolderDepth(string $name): string
    {
        $folderLength =  count(explode('/', $name));
        $basePath = '/*';
        $repeatedPath = str_repeat($basePath, $folderLength);
        $model_files = glob('app/models' . $repeatedPath . '.php');
        $fileLength = count(explode('/', $model_files[0]));

        foreach ($model_files as $file) {
            $path = '';
            $fileName =  explode('/', $file);
            for ($i = 2; $i < $fileLength; $i++) {
                $path .= $fileName[$i] . '/';
            }
            $path = rtrim($path, '/');
            if (strtolower($path) === strtolower($name . '.php')) {
                $fileName = $path;
                break;
            }
        }
        return $fileName;
    }
}
