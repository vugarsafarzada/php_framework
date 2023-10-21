<?php
function router(array $request): void
{
    $path = setControllerPath($request);
    if(file_exists($path)){
        RouteController($path, $request);
    } else {
        redirectNotAllowedPage();
    }
}