<?php
/**
 * Created by PhpStorm
 * User: Windqiu
 * Date: 2020/12/27
 * Time: 11:53
 */

namespace Foo\Bar;

include 'file1.php'; //导入 file1 文件

const FOO = 2;
function foo() {}
class foo
{
    static function staticmethod() {}
}

//todo 非限定名称
foo(); // 解析为当前命名空间下的 foo 函数，即 Foo\Bar\foo
foo::staticmethod(); // 解析为 Foo\Bar\foo，调用类 foo 的 staticmethod() 方法
echo FOO; // 解析为常量 Foo\Bar\Foo

//todo 限定名称
subnamespace\foo(); // 解析为函数 Foo\Bar\subnamespace\foo  file1下命名空间的
subnamespace\foo::staticmethod(); //解析为 Foo\Bar\subnamespace\foo, 类静态方法 staticmethod
echo subnamespace\FOO;

//todo 完全限定名称
\Foo\Bar\foo(); // 解析为 Foo\Bar\foo， 与 非限定类似
