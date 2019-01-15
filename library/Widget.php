<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Widget
{
    private static $_columnCount = 0; // 1 / 2 / 3
    private static $_widgetList = array('Aside', 'Post');
    private static $_widgetLoaded = array();

    public static $typechoWidget = null;

    public static function init($typechoWidget)
    {
        self::$_columnCount = 3;
        self::$typechoWidget = $typechoWidget;
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
        if (!in_array($name, self::$_widgetList))
            return false;
        if (!self::load($name))
            return;
        $params = func_get_args();
        array_shift($params);
        call_user_func_array(array('Icarus_Widget_' . $name, 'output'), $params);
    }
}