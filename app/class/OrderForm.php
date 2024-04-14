<?php
require_once 'Order.php';

class OrderForm
{
    private $html;
    private $data;

    public function __construct()
    {
        $file = dirname(__DIR__) . '/interfaces/form.html';
        $this->html = file_get_contents($file);
    }

    public function show()
    {
        print $this->html;
    }
}
