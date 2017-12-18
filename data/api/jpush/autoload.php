<?php
echo __DIR__;
echo JPUSH_PATH;
echo "<hr>";
//echo DIRECTORY_SEPARATOR;

function classLoader($class)
{
    echo JPUSH_PATH;
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = JPUSH_PATH . 'src'.DS .$path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');
