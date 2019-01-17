<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Config
{
    private $_form;

    const PREFIX = 'icarus_';

    public function __construct($form)
    {
        $this->_form = $form;
    }

    public static function prefixKey($key)
    {
        return self::PREFIX . $key;
    }

    private static function optionalDesc($key)
    {
        $key .= '.desc';
        if (Icarus_I18n::has($key))
        {
            return _IcT($key);
        }
        else
        {
            return null;
        }
    }

    public function makeHtml($html)
    {
        $this->_form->addItem((new Typecho_Widget_Helper_Layout())->html($html));
    }

    public function showBlock($content)
    {
        $this->makeHtml('<div>' . $content . '</div>');
    }

    public function showTitle($title)
    {
        $this->makeHtml('<h2>' . $title . '</h2>');
    }

    public function packTitle($name)
    {
        $langStr = 'setting.' . $name;
        $this->showTitle(_IcT($langStr . '.title'));
        if (Icarus_I18n::has($langStr . '.desc'))
        {
            $this->showBlock(_IcT($langStr . '.desc'));
        }
    }

    public function makeInput($name, $title, $desc, $default = null)
    {
        $this->_form->addInput(new Typecho_Widget_Helper_Form_Element_Text(
            self::prefixKey($name), null, $default, 
            $title, 
            $desc
        ));
    }

    public function packInput($name, $default = null)
    {
        $langStr = 'setting.' . str_replace('_', '.', $name);
        self::makeInput($name, _IcT($langStr . '.title'), self::optionalDesc($langStr), $default);
    }

    public function makeTextarea($name, $title, $desc, $default = null)
    {
        $this->_form->addInput(new Typecho_Widget_Helper_Form_Element_Textarea(
            self::prefixKey($name), null, $default, 
            $title, 
            $desc
        ));
    }

    public function packTextarea($name, $default = null)
    {
        $langStr = 'setting.' . str_replace('_', '.', $name);
        self::makeTextarea($name, _IcT($langStr . '.title'), self::optionalDesc($langStr), $default);
    }

    public function makeRadio($name, $title, $desc, array $options, $default = null)
    {
        $this->_form->addInput(new Typecho_Widget_Helper_Form_Element_Radio(
            self::prefixKey($name), $options, $default, 
            $title, 
            $desc
        ));
    }

    public function packRadio($name, array $options, $default = null)
    {
        $langStr = 'setting.' . str_replace('_', '.', $name);
        $optionsReal = array();
        foreach ($options as $option)
        {
            $optionsReal[$option] = _IcT($langStr . '.options.' . $option);
        }
        self::makeRadio($name, _IcT($langStr . '.title'), self::optionalDesc($langStr), $optionsReal, $default);
    }

    private static function configPreFilter($key)
    {
        return self::prefixKey($key);
    }

    public static function get($key, $default = null)
    {
        return self::tryGet($key, $result) ? $result: $default;
    }

    public static function has($key)
    {
        return self::tryGet($key, $result);
    }

    public static function callback($key, $callback)
    {
        if (self::tryGet($key, $result))
        {
            $callback($result);
        }
    }

    public static function tryGet($key, &$result)
    {
        $key = self::configPreFilter($key);
        $value = Icarus_Util::$options->$key;
        $exist = !is_null($value);
        if ($exist)
        {
            if (is_array($value))
                $exist = count($value) > 0;
            else if (is_string($value))
                $exist = strlen(trim($value)) != 0;
        }
        if ($exist)
            $result = $value;
        return $exist;
    }
}