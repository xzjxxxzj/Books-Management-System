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
        if (!$msg1 || !$msg2) {
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
}