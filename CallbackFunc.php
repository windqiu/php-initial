<?php
/**
 * User: Windqiu
 * Date: 2020/12/24
 * Time: 10:11
 * 回调函数使用
 */

class Product {
    public $name;

    public $price;

    function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale {
    private $callbacks;

    function registerCallback( $callback ) {
        if (! is_callable($callback)) {
            throw new Exception( "callback not callable");
        }

        $this->callbacks[] = $callback;
    }

    function sale( $product ) {
        print "{$product->name}: processing \n";
        foreach ($this->callbacks as $callback) {
            call_user_func($callback, $product);
        }
    }
}
//1-参数($a,$b,$c)。2-函数体
$logger = create_function('$product', 'print " logging({$product->name}) \n"; ');

$processor = new ProcessSale();
try {
    $processor->registerCallback($logger);
} catch (\Exception $e) {
    print $e->getMessage();
}

$processor->sale( new Product( "Shoes", 6 ));
print "\n";
$processor->sale( new Product( "Coffee", 6 ));
