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
     * 获取当前精确日期时间
     *
     * @param string $format
     * @param int $precision 1~6
     * @return string
     */
    public static function datetime(string $format = 'H:i:s', int $precision = 6)
    {
        return date($format) . substr(microtime(), 1, $precision + 1);
    }

    /**
     * 获取当前精确时间
     *
     * @param int $precision 1~6
     * @return string
     */
    public static function time(int $precision = 6)
    {
        [$float, $int] = explode(' ', microtime());
        return $int . substr($float, 1, $precision);
    }

    /**
     * 计算精确时间差
     *
     * @param string $start
     * @param string|null $end
     * @return float
     */
    public static function takeTime(string $start, ?string $end = null)
    {
        if ($end === null) {
            $end = microtime();
        }
        $int = substr($end, -10) - substr($start, -10);
        $float = substr($end, 0, 8) - substr($start, 0, 8);
        return round($int + $float, 6);
    }
}
