<?php
require_once 'Order.php';

class OrderList
{
    private $html;

    public function __construct()
    {
        $this->html = file_get_contents('../interfaces/list.html');
    }
}
