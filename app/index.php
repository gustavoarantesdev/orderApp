<?php

spl_autoload_register(function($class)
{
    if (file_exists($class . '.php'))
    {
        require_once $class . '.php';
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
