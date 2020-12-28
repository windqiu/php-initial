<?php
/**
 * Func:
 * Created by PhpStorm
 * User: Windqiu
 * Date: 2020/12/27
 */

namespace woo\base;

use A\B\C\Exception;

abstract class RegistryNew {
    abstract protected function get($key);
    abstract protected function set($key, $val);
}

/**
 * Func:请求级别注册表
 * @package woo\base
 */
class RequestRegistry extends RegistryNew {
    private $values = array();
    private static $instance;

    private function __construct() {}

    private function __clone() {}

    static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key) {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set($key, $val) {
        $this->values[$key] = $val;
    }

    static function getRequest() {
        return self::instance()->get('request');
    }

    static function setRequest(\woo\controller\Request $request) {
        return self::instance()->set('request', $request);
    }
}

/**
 * Func:会话级别注册表
 * @package woo\base
 */
class SessionRegistry extends RegistryNew {
    private static $instance;

    private function __construct() {
        session_start(); //开启会话
    }

    private function __clone() {}

    static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key) {
        if (!isset($_SESSION[__CLASS__][$key])) {
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }

    protected function set($key, $val) {
        $_SESSION[__CLASS__][$key] = $val;
    }

    static function getComplex() {
        return self::instance()->get('complex');
    }

    static function setComplex(Complex $complex) {
        self::instance()->set('complex', $complex);
    }

}

class ApplicationRegistry extends RegistryNew {
    private static $instance;
    private $freezedir = "data";
    private $values = array();
    private $mtimes = array();
    private function __construct() {}
    static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key) {
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        if (file_exists($path)) {
            //清楚文件状态缓存
            clearstatcache();
            //取得文件修改时间
            $mtime = filemtime($path);
            //不存在此 $key 修改时间时，默认0
            if (!isset($this->mtimes[$key])) {
                $this->mtimes[$key] = 0;
            }

            //当前文件修改时间，比已存在时间要 久时
            if ($mtime > $this->mtimes[$key]) {
                //读取最新文件内容
                $data = file_get_contents($path);
                //修改最新文件修改时间
                $this->mtimes[$key] = $mtime;
                // 将文件内容 反序列化后，存入容器中
                return ($this->values[$key] = unserialize($data));
            }

            if (isset($this->values[$key])) {
                return $this->values[$key];
            }
            return null;
        }
    }

    protected function set($key, $val) {
        $this->values[$key] = $val;
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        file_put_contents($path, serialize($val));
        $this->mtimes[$key] = time();
    }

    static function getDSN() {
        return self::instance()->get('dsn');
    }

    static function setDSN($dsn) {
        self::instance()->set('dsn', $dsn);
    }

}

/**
 * Func: 共享内存 shm拓展
 * @package woo\base
 */
class MemApplicationRegistry extends RegistryNew {
    private $values = array();
    private static $instance;
    private $id;
    const DSN = 1;

    private function __construct() {
        //key=内存id， memsize申请内存大小，perm权限
        $this->id = @shm_attach(55, 10000, 0600);
        if (!$this->id) {
            throw new \Exception("could not access shared memory");
        }
    }

    private function __clone() {}

    static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key) {
        return shm_get_var($this->id, $key);
    }

    protected function set($key, $val) {
        shm_put_var($this->id, $key, $val);
    }

    static function getDSN() {
        return self::instance()->get(self::DSN);
    }

    static function setRequest($dsn) {
        self::instance()->set(self::DSN, $dsn);
    }
}

class AppException extends \Exception {

}