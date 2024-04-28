<?php
require_once 'Order.php';

class OrderList
{
    private $html;

    public function __construct()
    {
        if (!isset($_REQUEST['method']))
        {
            $file = dirname(__DIR__) . '/interfaces/list.html';
            $this->html = file_get_contents($file);
        }
        else
        {
            $file = dirname(__DIR__) . '/interfaces/listAll.html';
            $this->html = file_get_contents($file);
        }
    }

    public function load()
    {
        try
        {
            $orders = Order::all();
         

            $elements = '';
            foreach ($orders as $order)
            {
                $element = dirname(__DIR__) . '/interfaces/element.html';
                $element = file_get_contents($element);

                $formattedEndDate = date('d/m/Y H:i', strtotime($order['enddate']));

                $element = str_replace('{id}',          $order['id'],          $element);
                $element = str_replace('{title}',       $order['title'],       $element);
                $element = str_replace('{client}',      $order['client'],      $element);
                $element = str_replace('{endDate}',     $formattedEndDate,     $element);
                $element = str_replace('{price}',       $order['price'],       $element);
                $element = str_replace('{paymentMethod}', $order['paymentmethod'], $element);

                $elements .= $element;
            }
            $this->html = str_replace('{elements}', $elements, $this->html);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }

    public function listAll()
    {
        try
        {
            $orders = Order::listAll();
         

            $elements = '';
            foreach ($orders as $order)
            {
                $element = dirname(__DIR__) . '/interfaces/itemListAll.html';
                $element = file_get_contents($element);

                $formattedEndDate = date('d/m/Y H:i', strtotime($order['enddate']));

                $element = str_replace('{id}',          $order['id'],          $element);
                $element = str_replace('{title}',       $order['title'],       $element);
                $element = str_replace('{client}',      $order['client'],      $element);
                $element = str_replace('{endDate}',     $formattedEndDate,     $element);
                $element = str_replace('{price}',       $order['price'],       $element);
                $element = str_replace('{paymentMethod}',       $order['paymentmethod'],       $element);
                $element = str_replace('{status}',       $order['finished'],       $element);

                $formattedEndDate = date('d/m/Y H:i', strtotime($order['creationdate']));

                $element = str_replace('{creationDate}',       $formattedEndDate,       $element);

                $elements .= $element;
            }
            $this->html = str_replace('{elements}', $elements, $this->html);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }


    public function show()
    {
        $this->load();
        print $this->html;
    }
}