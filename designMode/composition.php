<?php
/**
 * 【组合】
 * User: Windqiu
 * Date: 2020/12/27
 * Time: 13:45
 */

/**
 * Lesson类需要一个作为属性的 CostStrategy对象。
 * Lesson::cost() 方法只调用 CostStrategy::cost()
 *
 * 同样
 * Lesson::chargeType() 只调用 CostStrategy::chargeType()
 *
 * todo 像这样，显式调用另一个对象的方法来执行一个请求的方式，"委托"
 * CostStrategy 对象便是 Lesson 的委托方。 Lesson类不再负责计费，将计费任务传给 CostStrategy类
 *
 * 1/ 专注于职责
 * 2/ 通过组合提高灵活性
 * 3/ 使继承层级体系更紧凑和集中
 * 4/ 减少重复
 */

/**
 * todo 模式分类
 * 1/ 用于生成对象的模式
 * 2/ 用于组织对象和类的模式
 * 3/ 面向任务的模式
 * 4/ 企业模式
 * 5/ 数据库模式
 */

abstract class Lesson {
    private $duration;
    private $costStrategy;

    public function __construct($duration, CostStrategy $costStrategy) {
        $this->duration     = $duration;
        $this->costStrategy = $costStrategy;
    }

    public function cost() {
        return $this->costStrategy->cost($this);
    }

    public function chargeType() {
        return $this->costStrategy->chargeType();
    }

    public function getDuration() {
        return $this->duration;
    }
}

class Lecture extends Lesson {

}

class Seminar extends Lesson {

}

//使用策略模式进行计费, CostStrategy 负责计费，单一责任
abstract class CostStrategy {
    abstract public function cost(Lesson $lesson);

    abstract public function chargeType();
}

//固定收费类，继承父类
class FixedCostStrategy extends CostStrategy {

    public function cost(Lesson $lesson) {
        return 30;
    }

    public function chargeType() {
        return "Fixed Rate";
    }
}

class TimedCostStrategy extends CostStrategy {

    public function cost(Lesson $lesson) {
        return $lesson->getDuration() * 5;
    }

    public function chargeType() {
        return "Hourly Rate";
    }
}

$lessons[] = new Seminar(4, new TimedCostStrategy()); // 课程，按时付费
$lessons[] = new Lecture(4, new FixedCostStrategy()); // 演讲，固定付费

foreach ($lessons as $lesson) {
    print "lesson charge : {$lesson->cost()} .";
    print "Charge type : {$lesson->chargeType()} \n";
}
