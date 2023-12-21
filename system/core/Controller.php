<?php

namespace CompartSoftware\System\Core;

class Controller
{
    protected function view(string $name, array $data = []): void
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
        $fileName = $this->viewFolderDepth($name);
        require_once 'app/views/' . $fileName;
    }

    /**
     * @return mixed class
     */
    protected function model(string $name)
    {
        $fileName = $this->modelFolderDepth($name);
        require_once 'app/models/' . $fileName;
        $name =  explode('/', $name);
        $className = 'CompartSoftware\App\Model\\' . end($name);
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
