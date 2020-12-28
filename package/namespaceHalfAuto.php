<?php
/**
 * 动态语言
 * Created by PhpStorm
 * User: Windqiu
 * Date: 2020/12/27
 * Time: 12:18
 */

class classname
{
    function __construct()
    {
        echo __METHOD__ , "\n";
    }
}

function funcname()
{
    echo __FUNCTION__ , "\n";
}

const CONSTNAME = 'global';

/** 动态的类名称、函数名称或常量名称，限定名称和完全限定名称没有区别，所以反斜杠没有必要 */
$a = 'classname';
$obj = new $a; //实例化类 classname
$b = 'funcname';
$b(); //调用 funcname 函数
echo constant('CONSTNAME') , "\n";