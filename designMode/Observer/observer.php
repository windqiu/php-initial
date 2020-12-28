<?php
/**
 * Func: 观察者模式
 * 对象间的一种一对多的组合关系，以便一个对象的状态发生改变时，所有依赖它的对象都得到通知并自动刷新
 * User: Windqiu
 * Date: 2020/12/27
 */

namespace Observer;

interface Observer {
    function notice_receive($info = null);
}

/**
 * Func: 事件产生者（被观察者）
 * @package Observer
 */
abstract class EventAbstract {
    //保存观察者实例
    private $observers = array();
    //事件触发
    public abstract function trigger();
    //添加观察者
    function addObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    //通知观察者
    function notify() {
        foreach ($this->observers as $observer) {
            $observer->notice_receive();
        }
    }
}

/**
 * Func: 具体事件
 * @package Observer
 */
class Event extends EventAbstract {

    public function trigger() {
        echo "start to event \n";
        echo "notify after finished \n";
        $this->notify();
    }
}

/* 观察者1号 */
class ObserveOne implements Observer {

    function notice_receive($info = null) {
        echo "this is 1 of observer \n";
    }
}

/* 观察者2号 */
class ObserveTwo implements Observer {

    function notice_receive($info = null) {
        echo "this is 2 of observer \n";
    }
}

class Client {
    static function test() {
        $observerone = new ObserveOne();
        $observertwo = new ObserveTwo();

        //实例化事件
        $event = new Event();
        $event->addObserver($observerone);
        $event->addObserver($observertwo);
        $event->trigger();
    }
}

Client::test();