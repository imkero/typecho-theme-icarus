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

    public static function getAvatar($email, $size)
    {
        return self::getGravatar($email, Icarus_Assets::getGravatarUrl(), $size, Icarus_Config::get('comments_default_avatar'));
    }

    public static function getGravatar($email, $host, $size, $default = null)
    {
        $rating = Icarus_Util::$options->commentsAvatarRating;
        $hash = md5(strtolower($email));
        $avatar = $host . '/' . $hash . '?s=' . $size . '&r=' . $rating;
        if (!empty($default)) {
            $avatar .= '&d=' . urlencode($default);
        }
        return $avatar;
    }

    public static function getSiteInstallTime()
    {
        $time = FALSE;
        $typechoCfgFile = __TYPECHO_ROOT_DIR__ . '/config.inc.php';
        if (file_exists($typechoCfgFile))
        {
            $time = @filemtime($typechoCfgFile);
        }
        return $time === FALSE ? time() : $time;
    }

    public static function getSiteRunDays()
    {
        if (Icarus_Config::tryGet('general_install_time', $installTime))
        {
            $date = DateTime::createFromFormat('Y-m-d', $installTime);
        }
        else
        {
            $date = new DateTime();
        }
        $curDate = new DateTime();
        $interval = $date->diff($curDate);
        return $interval->format('%a');
    }

    public static function getSiteInstallYear()
    {
        if (Icarus_Config::tryGet('general_install_time', $installTime))
        {
            $date = DateTime::createFromFormat('Y-m-d', $installTime);
        }
        else
        {
            $date = new DateTime();
        }
        return $date->format('Y');
    }

    /**
     * 字符串命名风格转换
     * @param string $name 字符串
     * @return string
     * 
     * @link https://github.com/top-think/thinkphp/blob/109bf30254a38651c21837633d9293a4065c300b/ThinkPHP/Common/functions.php#L497
     */
    public static function parseName($name)
    {        
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }

    /**
     * 自闭合html修复函数
     * 使用方法:
     * <code>
     * $input = '这是一段被截断的html文本<a href="#"';
     * echo Typecho_Common::fixHtml($input);
     * //output: 这是一段被截断的html文本
     * </code>
     * 
     * Typecho 17.10.30 版 fixHtml 函数不能正确处理 <br> 等自闭合标签
     * Commit c056f6c895f440b1d72fc1415878fb7541fc249f 修复了此问题
     *
     * @access public
     * @param string $string 需要修复处理的字符串
     * @return string
     * 
     * @link https://github.com/typecho/typecho/blob/c056f6c895f440b1d72fc1415878fb7541fc249f/var/Typecho/Common.php#L519
     */
    public static function fixHtml($string)
    {
        //关闭自闭合标签
        $startPos = strrpos($string, "<");
        if (false == $startPos) {
            return $string;
        }
        $trimString = substr($string, $startPos);
        if (false === strpos($trimString, ">")) {
            $string = substr($string, 0, $startPos);
        }
        //非自闭合html标签列表
        preg_match_all("/<([_0-9a-zA-Z-\:]+)\s*([^>]*)>/is", $string, $startTags);
        preg_match_all("/<\/([_0-9a-zA-Z-\:]+)>/is", $string, $closeTags);
        if (!empty($startTags[1]) && is_array($startTags[1])) {
            krsort($startTags[1]);
            $closeTagsIsArray = is_array($closeTags[1]);
            foreach ($startTags[1] as $key => $tag) {
                $attrLength = strlen($startTags[2][$key]);
                if ($attrLength > 0 && "/" == trim($startTags[2][$key][$attrLength - 1])) {
                    continue;
                }
                // 白名单
                if (preg_match("/^(area|base|br|col|embed|hr|img|input|keygen|link|meta|param|source|track|wbr)$/i", $tag)) {
                    continue;
                }
                if (!empty($closeTags[1]) && $closeTagsIsArray) {
                    if (false !== ($index = array_search($tag, $closeTags[1]))) {
                        unset($closeTags[1][$index]);
                        continue;
                    }
                }
                $string .= "</{$tag}>";
            }
        }
        return preg_replace("/\<br\s*\/\>\s*\<\/p\>/is", '</p>', $string);
    }

    public static function isEmpty($value)
    {
        $exist = !is_null($value);
        if ($exist)
        {
            if (is_array($value))
                $exist = count($value) > 0;
            else if (is_string($value))
                $exist = strlen(trim($value)) > 0;
        }
        return !$exist;
    }

    public static function urlFor($type, $param)
    {
        return Typecho_Common::url(Typecho_Router::url($type, $param), self::$options->index);
    }

    public static function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}