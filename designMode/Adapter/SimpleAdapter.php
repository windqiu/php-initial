<?php
/**
 * Func: 适配器模式 - 结构型模式
 * Created by PhpStorm
 * User: Windqiu
 * Date: 2020/12/28
 */

class Weather {
    public static function show() {
        $info = array(
            'temperature' => '25℃',
            'wind' => '西北风',
            'weather' => 'sunny',
            'PM2.5' => 60
        );
        return serialize($info);
    }
}

//PHP调用
$msg = Weather::show(); //返回序列化的
$msg_arr = unserialize($msg); //恢复正常

//如果Java 或 python 需要，增加适配器
class WeatherAdapter extends Weather {
    //继承天气，并继承并重写该接口
    public static function show() {
        $info = parent::show();
        $info_arr = unserialize($info);
        //将数组进行 json化
        return json_encode($info_arr);
    }
}

//Java、python 调用
$msg = WeatherAdapter::show();