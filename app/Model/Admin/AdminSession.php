<?php

namespace App\Model\Admin;

use Illuminate\Support\Facades\Session;

class AdminSession
{
    private static $Key = 'admin';
    
    /**
     * 设置后台管理员SESSION
     * @param string or array $value
     */
    public static function setAdminInfo($key, $value)
    {
        if (is_object($value) || is_array($value)) {
             
            $value = serialize($value);
        }
        $key = self::$Key . '.' . $key;
        Session::put($key, $value);
        Session::save();
    }
    
    /**
     * 获取后台管理员SESSION
     * @return boolean or array
     */
    public static function getAdminInfo($key = '')
    {
        $key = empty($key) ? self::$Key : self::$Key . '.' . $key;
        $get = Session::get($key, false);
        if ($get) {
            $get = unserialize($get);
        }
        return $get;
    }
    
    /**
     * 删除后台管理员SESSION
     * @param string $key
     */
    public static function clearAdminInfo($key = '')
    {
        $key = empty($key) ? self::$Key : self::$Key . '.' . $key;
        Session::forget($key);
    }
}
