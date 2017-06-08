<?php

include 'methods.php';



// класс данных
class Data
{
    public $function;
    public $a ;
    public $b ;
    public $accuracy;

    public function __construct()
    {
        $this->a = (double)$_GET['a'];
        $this->b = (double)$_GET['b'];
        $this->accuracy = (double)$_GET['accuracy'];
        $this->function = $_GET['function'];
    }
}

$Data = new Data();

// объявляем массив методов
$methods = [];

for ($i=0; $i < count($_GET['methods']); $i++) 
{ 
    array_push($methods, new Method($_GET['methods'][$i]));    
}

// высчитывает значение игрика для заданного икса
function equate($x)
{
    $x = (double)$x;
    global $Data;
    eval('$result =' . $Data->function . ';');
    // $result = 4* $x *log( $x )*log( $x ) - 4*sqrt(1+ $x ) + 5;
    return $result;
}

// расчет всех методов с погрешностями
for ($i=0 ; $i<count($methods) ; $i++)
    $methods[$i]->getAnswer();
    // $methods[$i]->answer =  sprintf("%.4f", ($methods[$i]->getValue()));

echo json_encode($methods);

?>