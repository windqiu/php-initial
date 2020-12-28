<?php
/**
 * 【继承】
 * User: Windqiu
 * Date: 2020/12/27
 * Time: 13:45
 */

/*
 * UML
 */

/**
 * Func: 单纯的继承，未能良好拓展
 * User: Windqiu
 * Date: 2020/12/27
 * Class Lesson
 */
class Lesson
{
    public function __construct() {}

    public function cost() {}

    public function chargeType() {}

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