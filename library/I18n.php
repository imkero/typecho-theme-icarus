<?php
class Icarus_I18n
{
    private static $_instance = null;

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
            return $this->_data[$key];
        } else {
            return null;
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
