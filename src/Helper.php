<?php

namespace chaser\helper;

/**
 * 帮助类
 *
 * @package chaser\helper
 */
class Helper
{
    /**
     * 批处理
     *
     * @param array|mixed $data
     * @param callable $callable
     * @return bool|mixed
     */
    public static function callableForBatch($data, callable $callable)
    {
        return is_array($data) ? array_walk($data, $callable) : call_user_func($callable, $data);
    }

    /**
     * 唯一性 24 位 16 进制串
     *
     * @return string
     */
    public static function uniqueHex24()
    {
        return bin2hex(pack('d', microtime(true)) . pack('N', mt_rand()));
    }

    /**
     * 获取当前精确日期时间（微秒）
     *
     * @param int $decimals 小数位 1~6
     * @return string
     */
    public static function datetime(int $decimals = 6)
    {
        return date('H:i:s') . substr(microtime(), 1, $decimals + 1);
    }

    /**
     * 获取当前精确时间（微秒）
     *
     * @param int $decimals 小数位 1~6
     * @return string
     */
    public static function time(int $decimals = 6)
    {
        [$float, $time] = explode(' ', microtime());
        return $time . substr($float, 1, $decimals);
    }

    /**
     * 计算时间差（微秒）
     *
     * @param string $start
     * @param string|null $end
     * @return float
     */
    public static function takeTime(string $start, string $end = null)
    {
        if ($end === null) {
            $end = microtime();
        }
        $int = substr($end, -10) - substr($start, -10);
        $float = substr($end, 0, 8) - substr($start, 0, 8);
        return round($int + $float, 6);
    }
}
