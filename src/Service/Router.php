<?php
namespace App\Service;

class Router
{
    public function generatePath(string $action, ?array $params = [], $includeFC = true): string
    {
        $query = http_build_query(array_merge(['action' => $action], $params));
        $path = $includeFC ? "/index.php?$query" : "/$query";
        return $path;
    }

    public function redirect($path): string
    {
        header("Location: $path");
    }
}
