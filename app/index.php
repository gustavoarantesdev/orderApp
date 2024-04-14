<?php

spl_autoload_register(function($class)
{
    $file = __DIR__ . '/class/' . $class . '.php';
    if (file_exists($file))
    {
        require_once $file;
    }
});

$class = isset($_REQUEST['class']) ? $_REQUEST['class'] : $_REQUEST['class'] = 'OrderList';
$method = isset($_REQUEST['method']) ? $_REQUEST['method'] : null;

if (!empty($class) && class_exists($class))
{
    $page = new $class($_GET);

    if (!empty($method) && method_exists($class, $method))
    {
        $page->$method($_GET);
    }

    $page->show();
}
