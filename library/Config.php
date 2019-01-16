<?php
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

    public function makeHtml($html)
    {
        $this->_form->addItem((new Typecho_Widget_Helper_Layout())->html($html));
    }

    public function showTitle($title)
    {
        $this->makeHtml('<h2>' . $title . '</h2>');
    }

    public function showBlock($content)
    {
        $this->makeHtml('<div>' . $content . '</div>');
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

    public function packInput($name, $default = null)
    {
        $langStr = 'setting.' . str_replace('_', '.', $name);
        $this->_form->addInput(new Typecho_Widget_Helper_Form_Element_Text(
            self::prefixKey($name), null, $default, 
            _IcT($langStr . '.title'), 
            _IcT($langStr . '.desc')
        ));
    }

    public function makeInput($name, $title, $desc, $default = null)
    {
        $this->_form->addInput(new Typecho_Widget_Helper_Form_Element_Text(
            self::prefixKey($name), null, $default, 
            $title, 
            $desc
        ));
    }

    public static function get($key, $default = null)
    {
        $key = self::prefixKey($key);
        $result = Icarus_Util::$options->$key;
        return empty($result) ? $default : $result;
    }

    public static function has($key)
    {
        $key = self::prefixKey($key);
        $result = Icarus_Util::$options->$key;
        return !empty($result);
    }
}