<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Widget
{
    private static $_columnCount = 1; // 1 / 2 / 3
    private static $_widgetList = array('Aside', 'Post', 'Comments', 'Donate', 'Navbar', 'Share', 'Search', 'Profile');
    private static $_widgetAsideList = array('Aside', 'Post', 'Comments', 'Donate', 'Navbar', 'Share', 'Search', 'Profile');
    private static $_widgetLoaded = array();
    
    public static function init()
    {
        // dummy
        self::$_columnCount = 3;
    }

    public static function getColumnCount()
    {
        return self::$_columnCount;
    }

    public static function load($name)
    {
        if (!in_array($name, self::$_widgetList))
            return false;
        if (!in_array($name, self::$_widgetLoaded)) {
            require __ICARUS_ROOT__ . 'library/Widget/' . $name . '.php';
            self::$_widgetLoaded[] = $name;
        }
        return true;
    }

    public static function show($name)
    {
        if (!self::load($name))
            return;
        $params = func_get_args();
        array_shift($params);
        call_user_func_array(array('Icarus_Widget_' . $name, 'output'), $params);
    }

    public static function enabled($name)
    {
        return Icarus_Config::get(strtolower($name) . '_enable', false) == true;
    }

    public static function getWidgetSide($name)
    {
        // 0: left; 1: right
        return Icarus_Config::get(strtolower($name) . '_side', 0);
    }
}