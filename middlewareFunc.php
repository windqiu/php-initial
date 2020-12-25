<?php
/**
 * Created by PhpStorm
 * User: Windqiu
 * Date: 2020/12/24
 * Time: 23:36
 */

Interface Middleware{
    public static function handle(Closure $next);
}

class VerfiyCsrfToken implements Middleware {

    public static function handle(Closure $next) {
        echo "到了Token，下一步是next()\n" . PHP_EOL;
        $next();
    }
}

class VerfiyAuth implements Middleware {
    public static function handle(Closure $next) {
        echo "到了Auth了 \n" . PHP_EOL;
        $next();
    }
}

class SetCookie implements Middleware {
    public static function handle(Closure $next) {
        echo "到 cookie\n" . PHP_EOL;
        $next();
    }
}

function call_middleware() {
    SetCookie::handle(function() {
        VerfiyAuth::handle(function() {
           $handle = function() {
               echo "这里是handle";
           };
           VerfiyCsrfToken::handle($handle);
        });
    });
}

//call_middleware();


$handle = function() {
    echo "这里是handle";
};

$pipe_arr = [
    'VerfiyCsrfToken', //1
    'VerfiyAuth', //2
    'SetCookie', //3
];

/**
 * todo 第一个参数，必须是数组格式
 *
 * todo 第二个参数，是一个匿名函数，可以直接函数体，也可以是字符串指定函数名
 * 匿名函数：function($stack, $pipe)
 * $stack 第一次默认取，array_reduce的第三个参数作为初始值，如果为空，则为NULL
 *        第二次开始，以上一次的返回值作为初始值
 * $pipe  取第一个参数数组的第一个元素，每次都会将指针指向数组的下一个元素
 *
 * todo 第三个参数，是初始值，可选，为空时，执行第二个参数时，$stack为空，否则会把此参数作为 初始值赋值给$stack
 * $initial 第二个参数匿名函数的第一个参数初始值。
 *
 * array_reduce 当第一个数组已经执行完毕之后，不再进行迭代，将执行初始值，初始值的$handle则为一个匿名函数，可以作为闭包传递给 call_user_func
 *
 * $callback 必须是返回一个函数
 */

$callback = array_reduce($pipe_arr, function($stack, $pipe) {
    return function() use ($stack, $pipe) {
        return $pipe::handle($stack);
    };
}, $handle);

/**
 * call_user_func 必须接受一个回调函数
 */
call_user_func($callback);