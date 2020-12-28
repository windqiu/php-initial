<?php
/**
 * Created by PhpStorm
 * User: Windqiu
 * Date: 2020/12/27
 * Time: 11:59
 */

namespace Foo;

function strlen(){}

const INI_ALL = 2;

class Exception{}

//todo 访问全局，非本命名空间中
$a = \strlen('hello');
$b = \INI_ALL;
$c = new \Exception('eee');