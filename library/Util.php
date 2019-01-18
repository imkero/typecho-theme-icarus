<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Util
{
    public static $options;
    public static $widget;

    public static function init($typechoWidget)
    {
        Typecho_Widget::widget('Widget_Options')->to(self::$options);
        self::$widget = $typechoWidget;
    }

    public static function request()
    {
        return self::$widget->request;
    }

    public static function stat()
    {
        return Typecho_Widget::widget('Widget_Stat');
    }

    public static function strStartsWith($str, $startsWith)
    {
        return substr($str, 0, strlen($startsWith)) === $startsWith;
    }

    public static function isUrl($path)
    {
        return self::strStartsWith($path, "https://") || self::strStartsWith($path, "http://") || self::strStartsWith($path, "//");
    }

    public static function parseMultilineData($str, $columnCount)
    {
        $result = array();
        if (!empty($str)) {
            $data = explode("\n", $str);
            foreach ($data as $item) {
                $item = trim($item);
                if (!empty($item)) {
                    $itemData = explode(',', $item, $columnCount);
                    if (count($itemData) == $columnCount) {
                        foreach ($itemData as $k => $v) {
                            $itemData[$k] = trim($v);
                        }
                        $result[] = $itemData;
                    }
                }
            }
        }
        return $result;
    }

    public static function getAvatar($email, $size, $default = null)
    {
        return self::getGravatar($email, Icarus_Config::get('gravatar_cdn', 'https://cdn.v2ex.com/gravatar'), $size, $default);
    }

    public static function getGravatar($email, $host, $size, $default = null)
    {
        $rating = Icarus_Util::$options->commentsAvatarRating;
        $hash = md5(strtolower($email));
        $avatar = $host . '/' . $hash . '?s=' . $size . '&r=' . $rating;
        if (!empty($default)) {
            $avatar .= '&d=' . $default;
        }
        return $avatar;
    }
}