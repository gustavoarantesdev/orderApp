<?php
require_once 'Order.php';

class OrderForm
{
    private $html;
    private $data;

    public function __construct()
    {
        $this->html = file_get_contents('../interfaces/form.html');
    }
}
