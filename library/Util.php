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
    public static function hasThumbnail($post)
    {
        // dummy
        return FALSE;
    }

    public static function getThumbnail($post)
    {
        if (self::hasThumbnail($post)) {
            // dummy
            return 'http://ppoffice.github.io/hexo-theme-icarus/gallery/preview.png';
        } else {
            return Icarus_Assets::getUrlForAssets('img/thumbnail.svg');
        }
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
     * 修复因截断而不完整的html（只能处理截断前是完整状态的html）
     * 
     * 使用方法:
     * <code>
     * $input = '这是一段被截断的html文本<a href="#"';
     * echo Typecho_Common::fixHtml($input);
     * //output: 这是一段被截断的html文本
     * </code>
     *
     * @access public
     * @param string $string 需要修复处理的字符串
     * @return string
     */
    public static function fixHtml($string)
    {
        $lastStartTagPos = strrpos($string, "<");

        // any tag not found
        if (FALSE === $lastStartTagPos) {
            return $string;
        }

        // remove last unstarted tag like '<a href="#"'
        if (FALSE === strpos($string, ">", $lastStartTagPos + 1)) {
            $string = substr($string, 0, $lastStartTagPos);
        }

        // regex match start tags
        preg_match_all("/<([_0-9a-zA-Z-\:]+)\s*([^>]*)>/is", $string, $startTags);
        
        // regex match end tags
        preg_match_all("/<\/([_0-9a-zA-Z-\:]+)>/is", $string, $closeTags);

        if (!empty($startTags[1]) && is_array($startTags[1])) {
            // reverse start tags list
            krsort($startTags[1]);

            $closeTagsAvailable = !empty($closeTags[1]) && is_array($closeTags[1]);

            foreach ($startTags[1] as $key => $tag) {
                $attrLength = strlen($startTags[2][$key]);
                
                // self-closed tags
                if ($attrLength > 0 && "/" == $startTags[2][$key][$attrLength - 1]) {
                    continue;
                }

                // single tag white list
                if (in_array($tag, array('img', 'br'))) {
                    continue;
                }

                // decrease correspondent close tag's count
                if ($closeTagsAvailable) {
                    if (FALSE !== ($index = array_search($tag, $closeTags[1]))) {
                        unset($closeTags[1][$index]);
                        continue;
                    }
                }
                $string .= "</{$tag}>";
            }
        }

        return preg_replace("/\<br\s*[\/]?\>\s*\<\/p\>/is", '</p>', $string);
    }
}