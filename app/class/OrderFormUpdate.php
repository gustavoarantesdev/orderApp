<?php
require_once 'Order.php';

class OrderFormUpdate
{
    private $html;
    private $data;

    public function __construct()
    {
        $file = dirname(__DIR__) . '/interfaces/updateForm.html';
        $this->html = file_get_contents($file);
    }

    public function update($param)
    {
        try
        {
            $id = (int) $param['id'];
            $this->data = Order::find($id);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }

    public function save($param)
    {
        try
        {
            $finished = isset($param['finished']) && $param['finished'] === 't' ? 't' : 'f';
            $param['finished'] = $finished;

            Order::save($param);
            $this->data = $param;
            print "Cadastrado com Sucesso";
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }

    public function delete($param)
    {
        try
        {
            $id = (int) $param['id'];
            Order::delete($id);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }

    public function show()
    {
        $this->html = str_replace('{id}',      (string) $this->data['id'],      $this->html);
        $this->html = str_replace('{title}',   (string) $this->data['title'],   $this->html);
        $this->html = str_replace('{client}',  (string) $this->data['client'],  $this->html);
        $this->html = str_replace('{endDate}', (string) $this->data['enddate'], $this->html);
        $this->html = str_replace('{price}',   (string) $this->data['price'],   $this->html);

        $paymentMethod = $this->data['paymentmethod'];
        $this->html = str_replace("value=\"$paymentMethod\"", "value=\"$paymentMethod\" selected", $this->html);    

        $this->html = str_replace('{description}', (string) $this->data['description'], $this->html);

        $finishedChecked = ($this->data['finished'] == 1) ? 'checked' : '';
        $this->html = str_replace('<input class="form-check-input" type="checkbox" name="finished" value="t">',
                                  '<input class="form-check-input" type="checkbox" name="finished" value="t" ' . $finishedChecked . '>',
                      $this->html);
 
        $formattedDate = Utility::dateFormat($this->data['creationdate'], false);
        $this->html = str_replace('{creationDate}', (string) $formattedDate, $this->html);

        print $this->html;
    }
}