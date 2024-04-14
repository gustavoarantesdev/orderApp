<?php
require_once 'Order.php';

class OrderList
{
    private $html;

    public function __construct()
    {
        $file = dirname(__DIR__) . '/interfaces/list.html';
        $this->html = file_get_contents($file);
    }
}
