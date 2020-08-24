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
     * @param mixed ...$args
     * @return bool|mixed
     */
    public static function callableForBatch($data, callable $callable, ...$args)
    {
        return is_array($data) ? array_walk($data, $callable, ...$args) : call_user_func($callable, $data, null, ...$args);
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
    public static function datetime(string $format = 'Y-m-d H:i:s', int $precision = 6)
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

    /**
     * 银行卡校验
     *
     * @param string $number
     * @return bool
     */
    public static function bankCardCheck(string $number)
    {
        $length = strlen($number);
        $oddSum = $evenSum = 0;
        $isOdd = true;
        for ($i = $length - 1; $i >= 0; $i--) {
            if ($isOdd) {
                $oddSum += $number[$i];
            } else {
                $even = $number[$i] * 2;
                $even > 9 && $even -= 9;
                $evenSum += $even;
            }
            $isOdd = !$isOdd;
        }
        return ($oddSum + $evenSum) % 10 === 0;
    }

    /**
     * 身份证校验
     *
     * @param string $number
     * @return bool
     */
    public static function idCardCheck(string $number)
    {
        if (strlen($number) !== 18) {
            return false;
        }

        $weight = 0;

        // 权值
        $W = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];

        // 校验码
        $Y = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];

        for ($i = 0; $i < 17; $i++) {
            $weight += $number[$i] * $W[$i];
        }

        return $Y[$weight % 11] === substr($number, -1);
    }

    /**
     * 截取文本
     *
     * @param string $text
     * @param int $length
     * @param string $charset
     * @return string
     */
    public static function cutText(string $text, int $length, $charset = 'utf-8')
    {
        $mbLength = mb_strlen($text, $charset);
        return $mbLength > $length ? mb_substr($text, 0, max($length - 2, 0), $charset) . '...' : $text;
    }

    /**
     * 是否支持端口复用
     *
     * @return bool
     */
    public static function reusePort()
    {
        return PHP_OS === 'Linux' && version_compare(php_uname('r'), '3.9', '>=');
    }
}
