<?php
/**
 * Created by PhpStorm
 * User: Windqiu
 * Date: 2020/12/27
 * Time: 12:13
 */

namespace A\B\C;

class Exception extends \Exception
{}

$a = new Exception('hi'); //访问本类 A\B\C\Exception
$b = new \Exception('hi'); //访问全局类


/** 对于函数和常量而言，如果当前命名空间中不存在该函数或常量，PHP会退而使用全局空间中的函数或常量 */
//会报错，因为本命名空间中，没有 ArrayObject类
//$c = new ArrayObject();
