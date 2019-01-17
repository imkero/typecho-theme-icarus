<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Widget
{
    private static $_columnCount = 1; // 1 / 2 / 3
    private static $_widgetList = array('Aside', 'Post', 'Comments', 'Donate', 'Navbar', 'Share', 'Search', 'Profile');
    private static $_widgetLoaded = array();

    public static $widgetLeft = null;
    public static $widgetRight = null;
    
    public static function init()
    {
        self::$_columnCount = 1;
        
        self::load('Aside');
        self::$widgetLeft = new Icarus_Widget_Aside(false);
        self::$widgetRight = new Icarus_Widget_Aside(true);
        self::$_columnCount += self::$widgetLeft->count() > 0;
        self::$_columnCount += self::$widgetRight->count() > 0;
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