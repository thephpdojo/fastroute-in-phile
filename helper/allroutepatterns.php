<?php
function _glob_recursive($pattern, $flags = 0) {
    // The initial call to glob() gets the files matching the pattern in the current directory
    $files = glob($pattern, $flags);

    // glob() is then used to find all subdirectories in the current directory
    foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
        // Recursively call glob_recursive for each subdirectory
        // This merges the files from the subdirectories into the main files array
        $files = array_merge($files, _glob_recursive($dir . '/' . basename($pattern), $flags));
    }

    return $files;
}

function allroutepatterns() {
    $routeFiles = _glob_recursive(__DIR__ . "/../route/*.php");

    foreach($routeFiles as $index => $routeFile) {
        $routeFiles[$index] = str_replace(
            [".php","."],["","/"],
            str_replace(__DIR__ . "/../route", "", $routeFile
            )
        );
    }

    return $routeFiles;
}
