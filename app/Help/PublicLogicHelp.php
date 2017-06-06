<?php

/**
 * 公共函数存放位置
 * @author dazhen
 */

if (!function_exists('getIp')) {

    /**
     * 获取用户IP地址
     */
    function getIp()
    {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('REMOTE_ADDR')) {
            $ip = getenv('REMOTE_ADDR');
        } else {
            $ip = "";
        }
        return $ip;
    }
}

if(!function_exists('jumpPage'))
{
    /**
     * 成功或者错误页跳转
     * @param bool $type 1 成功页 2失败页
     * @param string $pagetitle 标题
     * @param string $msg1 链接1
     * @param string $msg2 链接2
     */

    function jumpPage($type = true, $pagetitle = '', $msg1 = '', $msg2 = '')
    {
        if (($msg1 && !is_array($msg1)) || ($msg2 && !is_array($msg2))) {
            return false;
        }
        if (!$msg1 && !$msg2) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                $msg1['返回'] = $_SERVER['HTTP_REFERER'];
            }
        }
        $data['msg1'] = $msg1;
        if (!$msg2) {
            $data['msg2'] = $msg2;
        }
        if (($pagetitle && is_array($pagetitle))) {
            $data['title'] = key($pagetitle);
            $data['miaoshu'] = current($pagetitle);
        }
        $data['type'] = $type;
        return view('admin.jump.jump', $data);
    }

    if (!function_exists('timeDiff')) {
        /**
         * 计算两个时间差
         * @param str $time1 起始时间
         * @param str $time2 结束时间
         * @param str $format 获取参数
         * @return str
         */
        function timeDiff($time1, $time2, $format = 'y年m月d天h小时i分s秒')
        {
            if ($time1>$time2) {
                return false;
            }
            $date1 = new DateTime($time1);
            $date2 = new DateTime($time2);
            $interval = $date1->diff($date2);
            $interval = get_object_vars($interval);
            foreach (array_reverse($interval) as $key => $value) {
                $format = str_replace($key, $value, $format);
            }
            return $format;
        }
    }

    if (!function_exists('objectToArray')) {
        /**
         * 对象转数组
         * @param object $object 对象
         * @return array
         */
        function objectToArray($object)
        {
            if (!is_object($object) && !is_array($object)) {
                return $object;
            }
            return json_decode(json_encode($object), true);
        }
    }
}