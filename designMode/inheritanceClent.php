<?php
/**
 * 【继承-客户端】
 * User: Windqiu
 * Date: 2020/12/27
 * Time: 13:45
 */

/*
 * UML
 */
abstract class Lesson
{
    protected $duration;
    const FIXED = 1;
    const TIMED = 2;
    private $costtype;

    public function __construct($duration, $costtype = 1)
    {
        $this->duration = $duration;
        $this->costtype = $costtype;
    }

    public function cost()
    {
        switch ($this->costtype)
        {
            case self::TIMED :
                return ( 5 * $this->duration );
            case self::FIXED :
                return 30;
            default :
                $this->costtype = self::FIXED;
                return 30;
        }
    }

    public function chargeType()
    {
        switch ($this->costtype)
        {
            case self::TIMED :
                return "hourly rate";
            case self::FIXED :
                return "fixed rate";
            default :
                $this->costtype = self::FIXED;
                return "fixed rate";
        }
    }

}

class FixedPriceLesson extends Lesson
{
    public function cost() {}

    public function chargeType() {}
}

class TimedPriceLesson extends Lesson
{
    public function cost() {}
    public function chargeType() {}
}

//------------------------------------
//如果分为 课程和演讲
class Lecture extends Lesson {}

class FixedPriceLecture extends Lecture
{
    public function cost() {}
    public function chargeType() {}
}

class TimedPriceLecture extends Lecture
{
    public function cost() {}
    public function chargeType() {}
}

class Seminar extends Lesson {}

class FixedPriceSeminar extends Seminar
{
    public function cost() {}
    public function chargeType() {}
}

class TimedPriceSeminar extends Seminar
{
    public function cost() {}
    public function chargeType() {}
}

$lecture = new Lecture(5, Lesson::FIXED);
print "{$lecture->cost()} ({$lecture->chargeType()}) \n";

$seminar = new Seminar(3, Lesson::TIMED);
print "{$seminar->cost()} ({$seminar->chargeType()})";