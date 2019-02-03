<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_I18n
{
    private static $_instance = NULL;

    private $_lang;
    private $_data;

    private function __construct($lang, $data)
    {
        $this->_lang = $lang;
        $this->_data = array();
        if (is_array($data)) {
            self::processTranslation($data, $this->_data);
        }
    }

    private static function processTranslation($data, &$result, $baseKey = '')
    {
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                self::processTranslation($v, $result, $baseKey . $k . '.');
            } else {
                $result[$baseKey . $k] = $v;
            }
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            $curLang = Icarus_Util::$options->lang;
            if (!preg_match('/^[a-zA-Z0-9-_]+$/', $curLang))
                $curLang = 'zh_CN';
            
            $langFile = __ICARUS_ROOT__ . 'lang/' . $curLang . '.php';
            $langData = file_exists($langFile) ? require $langFile : array();
            
            self::$_instance = new self($curLang, $langData);
        }
        return self::$_instance;
    }

    public static function init()
    {
        self::getInstance();
    }

    public function hasTranslation($key)
    {
        return array_key_exists($key, $this->_data);
    }

    public function getTranslation($key)
    {
        if ($this->hasTranslation($key)) {
            $translation = $this->_data[$key];
            if (strlen($translation) > 0 && $translation[0] == '@')
                return $this->getTranslation(substr($translation, 1));
            else
                return $translation;
        } else {
            return NULL;
        }
    }

    public static function get($key)
    {
        $lang = self::getInstance();
        $result = $lang->getTranslation($key);
        return is_null($result) ? $key : $result;
    }

    public static function has($key)
    {
        $lang = self::getInstance();
        return $lang->hasTranslation($key);
    }
}
