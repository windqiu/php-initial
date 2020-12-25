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
            var_dump($callback);
            call_user_func($callback, $product);
        }
    }
}

class Mailer {
    function doMail($product) {
        print " mailing({$product->name}) \n";
    }
}

class Totalizer {
    static function warnAmount() {
        return function( $product ) {
            if ($product->price > 5) {
                print " reached hight price : {$product->price} \n";
            }
        };
    }
}

//1-参数($a,$b,$c)。2-函数体
$logger = create_function('$product', 'print " logging({$product->name}) \n"; ');

$processor = new ProcessSale();
try {
    //todo 1/使用直接方式，注册匿名函数
//    $processor->registerCallback($logger);
    //todo 2/使用数组形式，注册Mailer对象与方法，则调用doMail方法作为回调
//    $processor->registerCallback(array( new Mailer(), "doMail"));
    //todo 3/使用静态方法注册
    $processor->registerCallback(Totalizer::warnAmount());
} catch (\Exception $e) {
    print $e->getMessage();
}

$processor->sale( new Product( "Shoes", 6 ));
print "\n";
$processor->sale( new Product( "Coffee", 3 ));
