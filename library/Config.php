<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Config
{
    private $_form;

    const PREFIX = 'icarus_';

    public static function config($form)
    {
        $form->showTitle(_IcT('setting.general.title'));
        $form->makeHtml(sprintf(_IcT('setting.general.desc'), __TYPECHO_THEME_DIR__ . '/' . Icarus_Util::$options->theme));

        $form->packInput('general_install_time', date('Y-m-d', Icarus_Util::getSiteInstallTime()), 'w-20');
    }

    public function __construct($form)
    {
        $this->_form = $form;
        $this->makeHtml('<style>.icarus-config-title{margin-top: 2em; margin-bottom: 0.2em; border-bottom: 1px solid #D9D9D6; padding-bottom: 0.2em;} .icarus-description{color: #999; font-size: .92857em;}</style>');
    }

    private static function prefixKey($key)
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
            return NULL;
        }
    }

    private static function cfgNameToI18n($cfgName)
    {
        $dashIndex = strpos($cfgName, '_');
        if ($dashIndex !== FALSE)
        {
            $cfgName[$dashIndex] = '.';
        }
        return 'setting.' . $cfgName;
    }

    public function makeHtml($html)
    {
        $layout = new Typecho_Widget_Helper_Layout();
        $layout->setTagName(NULL);
        $layout->html($html);
        $this->_form->addItem($layout);
    }

    public function showDesc($content)
    {
        $layout = new Typecho_Widget_Helper_Layout();
        $layout->setTagName('div');
        $layout->html($content);
        $layout->class = 'icarus-description';
        $this->_form->addItem($layout);
    }

    public function showTitle($title)
    {
        $layout = new Typecho_Widget_Helper_Layout();
        $layout->setTagName('h2');
        $layout->html($title);
        $layout->class = 'icarus-config-title';
        $this->_form->addItem($layout);
    }

    public function packTitle($name)
    {
        $langStr = self::cfgNameToI18n($name);
        $this->showTitle(_IcT($langStr . '.title'));
        if (Icarus_I18n::has($langStr . '.desc'))
        {
            $this->showDesc(_IcT($langStr . '.desc'));
        }
    }

    public function makeInput($name, $title, $desc, $default = NULL, $classAppend = NULL)
    {
        $input = new Typecho_Widget_Helper_Form_Element_Text(
            self::prefixKey($name), NULL, $default, 
            $title, 
            $desc
        );
        if (!empty($classAppend))
        {
            $input->input->setAttribute('class', $classAppend);
        }
        $this->_form->addInput($input);
        return $input;
    }

    public function makeIntInput($name, $title, $desc, $default = NULL, $classAppend = NULL)
    {
        $input = $this->makeInput($name, $title, $desc, $default, $classAppend);
        $input->addRule('isInteger', _t('请填入一个数字'));
        return $input;
    }

    public function packInput($name, $default = NULL, $classAppend = NULL)
    {
        $langStr = self::cfgNameToI18n($name);
        $this->makeInput($name, _IcT($langStr . '.title'), self::optionalDesc($langStr), $default, $classAppend);
    }

    public function makeTextarea($name, $title, $desc, $default = NULL)
    {
        $this->_form->addInput(new Typecho_Widget_Helper_Form_Element_Textarea(
            self::prefixKey($name), NULL, $default, 
            $title, 
            $desc
        ));
    }

    public function packTextarea($name, $default = NULL)
    {
        $langStr = self::cfgNameToI18n($name);
        $this->makeTextarea($name, _IcT($langStr . '.title'), self::optionalDesc($langStr), $default);
    }

    public function makeRadio($name, $title, $desc, array $options, $default = NULL)
    {
        $this->_form->addInput(new Typecho_Widget_Helper_Form_Element_Radio(
            self::prefixKey($name), $options, $default, 
            $title, 
            $desc
        ));
    }

    public function packRadio($name, array $options, $default = NULL)
    {
        $langStr = self::cfgNameToI18n($name);
        $optionsReal = array();
        foreach ($options as $option)
        {
            $optionsReal[$option] = _IcT($langStr . '.options.' . $option);
        }
        $this->makeRadio($name, _IcT($langStr . '.title'), self::optionalDesc($langStr), $optionsReal, $default);
    }

    private static function configPreFilter($key)
    {
        return self::prefixKey($key);
    }

    public static function get($key, $default = NULL)
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

    public static function getSiteRunDays()
    {
        if (self::tryGet('general_install_time', $installTime))
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
        if (self::tryGet('general_install_time', $installTime))
        {
            $date = DateTime::createFromFormat('Y-m-d', $installTime);
        }
        else
        {
            $date = new DateTime();
        }
        return $date->format('Y');
    }
}