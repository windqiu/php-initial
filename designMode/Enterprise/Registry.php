<?php
/**
 * Func:
 * User: Windqiu
 * Date: 2020/12/27
 */

class Registry {
    private static $instance;
    private static $testmode;
    private $values = array();

    private function __construct() {

    }

    private function __clone() {
        // TODO: Implement __clone() method.
    }

    /**
     * 针对测试时，改造 instance
     * stub对象：在测试中，代替真实环境的模拟对象
     * mock对象：与stub类似，可以分析对他们的滴啊用并作出响应
     */
    static function testMode($mode = true) {
        self::$instance = null;
        self::$testmode = $mode;
    }

    static function instance() {
        //如果测试模式存在，则切换到测试模式
        if (self::$testmode) {
            return new MockRegistry();
        }

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function get($key) {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    function set($key, $value) {
        $this->values[$key] = $value;
    }

    //TreeBuilder对象的客户类，调用 Registry::treeBuilder()，可以初始化 TreeBuilder类
    function treeBuilder() {
        if (!isset($this->treeBuilder)) {
            $this->treeBuilder = new TreeBuilder($this->conf()->get('treedir'));
        }

        return $this->treeBuilder;
    }

    function conf() {
        if (!isset($this->conf)) {
            $this->conf = new Conf();
        }
        return $this->conf;
    }
}

//切换到测试模式，客户端代码
Registry::testMode();
$mock = Registry::instance(); //这里已经切换到测试模式