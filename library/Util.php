<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Util
{
    public static $options;

    public static function init()
    {
        Typecho_Widget::widget('Widget_Options')->to(self::$options);
    }

    public static function strStartsWith($str, $startsWith)
    {
        return substr($str, 0, strlen($startsWith)) === $startsWith;
    }

    public static function isUrl($path)
    {
        return self::strStartsWith($path, "https://") || self::strStartsWith($path, "http://") || self::strStartsWith($path, "//");
    }
}