<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Config
{
    private $_form;
    private $_titleList = array();

    const PREFIX = 'icarus_';

    public static function config($form)
    {
        if (!self::cfgVersionMatch())
        {
            Typecho_Widget::widget('Widget_Notice')->set(sprintf(_IcT('setting.cfg_version_notice'), __ICARUS_VERSION__), 'notice');
        }

        $verInfo = new Icarus_Form_VersionField();
        $form->_form->addInput($verInfo);

        $style = <<<STYLESHEET
<style>
form code
{
    color: #e50833; 
    background: #fff; 
    padding: 2px 4px; 
    border-radius: 3px;
}
.icarus-config-title
{
    margin-top: 2em; 
    margin-bottom: 0.2em; 
    border-bottom: 1px solid #D9D9D6; 
    padding-bottom: 0.2em;
}
.icarus-description
{
    color: #999; 
    font-size: .92857em;
}
#icarus-config-toc
{
    position: relative;
    top: 0;
    padding: 15px 0 10px 20px;
    border: 2px solid #ccc;
    background: #eee;
}
#icarus-config-toc.hide
{
    display: none;
}
#icarus-config-toc > ul
{
    padding-left: 0;
    list-style: none;
    max-height: 400px;
    max-height: 75vh;
    overflow-y: scroll;
}
#icarus-config-toc > ul > li
{
    margin: 3px 0;
}
#icarus-config-toc > ul > li > a
{
    display: block;
    text-decoration: none;
    color: #444;
    padding: 1px 0 1px 8px;
    border-left: 2px solid #aaa;
}
#icarus-config-toc > ul > li > a:hover
{
    border-left-color: #666;
}
#icarus-config-toc > h2
{
    margin: 0 0 .5em 0;
}
#icarus-save-btn
{
    position: absolute;
    right: 10px;
    top: 20px;
}
@media (max-width: 1200px)
{
    #icarus-config-toc
    {
        width: 20%;
    }
}
@media (max-width: 768px)
{
    #icarus-config-toc
    {
        display: none;
    }
}

#icarus-config-toc > ul::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

#icarus-config-toc > ul::-webkit-scrollbar-thumb {
    background-color: rgba(50, 50, 50, .25);
    border: 2px solid transparent;
    background-clip: padding-box
}

#icarus-config-toc > ul::-webkit-scrollbar-thumb:hover {
    background-color: rgba(50, 50, 50, .5)
}

#icarus-config-toc > ul::-webkit-scrollbar-track {
    background-color: rgba(50, 50, 50, 0)
}
</style>
STYLESHEET;
        $form->html($style);

        $form->showTitle(_IcT('setting.general.title'), 'General');
        $form->html(sprintf(_IcT('setting.general.desc'), __TYPECHO_THEME_DIR__ . '/' . Icarus_Util::$options->theme));

        $form->packInput('General/install_time', date('Y-m-d', Icarus_Util::getSiteInstallTime()), 'w-20');
    }

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
            return NULL;
        }
    }

    private static function cfgNameToLangKey($cfgName)
    {
        $split = explode('/', $cfgName, 2);
        switch (count($split))
        {
            case 2:
                return 'setting.' . Icarus_Util::parseName($split[0]) . '.' . $split[1];
            case 1:
                return 'setting.' . Icarus_Util::parseName($cfgName);
        }
    }

    private static function cfgNameToCfgKey($cfgName)
    {
        $split = explode('/', $cfgName, 2);
        return Icarus_Util::parseName($split[0]) . '_' . $split[1];
    }

    public function html($html)
    {
        $layout = new Typecho_Widget_Helper_Layout(NULL);
        $layout->html($html);
        $this->_form->addItem($layout);
    }

    public function showDesc($content)
    {
        $layout = new Typecho_Widget_Helper_Layout('div');
        $layout->html($content);
        $layout->class = 'icarus-description';
        $this->_form->addItem($layout);
    }

    public function showTitle($title, $id = NULL)
    {
        static $titleCount = 0;
        $titleCount++;

        if (is_null($id)) {
            $id = 'Section-' . $titleCount;
        }

        $this->_titleList[] = array($title, $id);

        $layout = new Typecho_Widget_Helper_Layout('h2');
        $layout->id = $id;
        $layout->class = 'icarus-config-title';
        $layout->html($title);

        $this->_form->addItem($layout);
    }

    public function packTitle($name)
    {
        $langStr = self::cfgNameToLangKey($name);
        
        $this->showTitle(_IcT($langStr . '.title'), $name);
        if (Icarus_I18n::has($langStr . '.desc'))
        {
            $this->showDesc(_IcT($langStr . '.desc'));
        }
    }

    public function makeInput($name, $title, $desc, $default = NULL, $classAppend = NULL)
    {
        $input = new Icarus_Form_Element_Text(
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
        $langStr = self::cfgNameToLangKey($name);
        $this->makeInput(self::cfgNameToCfgKey($name), _IcT($langStr . '.title'), self::optionalDesc($langStr), $default, $classAppend);
    }

    public function makeTextarea($name, $title, $desc, $default = NULL)
    {
        $this->_form->addInput(new Icarus_Form_Element_Textarea(
            self::prefixKey($name), NULL, $default, 
            $title, 
            $desc
        ));
    }

    public function packTextarea($name, $default = NULL)
    {
        $langStr = self::cfgNameToLangKey($name);
        $this->makeTextarea(self::cfgNameToCfgKey($name), _IcT($langStr . '.title'), self::optionalDesc($langStr), $default);
    }

    public function makeRadio($name, $title, $desc, array $options, $default = NULL)
    {
        $this->_form->addInput(new Icarus_Form_Element_Radio(
            self::prefixKey($name), $options, $default, 
            $title, 
            $desc
        ));
    }

    public function packRadio($name, array $options, $default = NULL)
    {
        $langStr = self::cfgNameToLangKey($name);
        $optionsReal = array();
        foreach ($options as $option)
        {
            $optionsReal[$option] = _IcT($langStr . '.options.' . $option);
        }
        $this->makeRadio(self::cfgNameToCfgKey($name), _IcT($langStr . '.title'), self::optionalDesc($langStr), $optionsReal, $default);
    }

    public function makeCheckbox($name, $title, $desc, array $options)
    {
        $this->_form->addInput(new Icarus_Form_Element_Checkbox(
            self::prefixKey($name), $options, NULL, 
            $title, 
            $desc
        ));
    }

    public function packCheckbox($name, array $options)
    {
        $langStr = self::cfgNameToLangKey($name);
        $optionsReal = array();
        foreach ($options as $option)
        {
            $optionsReal[$option] = _IcT($langStr . '.options.' . $option);
        }
        $this->makeCheckbox(self::cfgNameToCfgKey($name), _IcT($langStr . '.title'), self::optionalDesc($langStr), $optionsReal);
    }

    public function toc()
    {
        $container = new Typecho_Widget_Helper_Layout('div');
        $container->id = 'icarus-config-toc';
        $container->class = 'col-mb-12 col-tb-2 hide';

        $container->addItem((new Typecho_Widget_Helper_Layout('h2'))->html('目录'));
        
        $button = new Typecho_Widget_Helper_Layout('button');
        $button->type = 'submit';
        $button->class = 'btn primary btn-xs';
        $button->id = 'icarus-save-btn';
        $button->html(_t('保存设置'));

        $container->addItem($button);

        $ul = new Typecho_Widget_Helper_Layout('ul');
        $container->addItem($ul);
        foreach ($this->_titleList as $title)
        {
            $li = new Typecho_Widget_Helper_Layout('li');
            $a = new Typecho_Widget_Helper_Layout('a');
            $a->href = '#' . $title[1];
            $a->html($title[0]);
            $li->addItem($a);
            $ul->addItem($li);
        }

        $script = new Typecho_Widget_Helper_Layout();
        $script->setTagName('script');
        $jsCode = <<<SCRIPT
document.addEventListener('DOMContentLoaded', function () {
    var toc = $('#icarus-config-toc');
    var mainForm = $('.typecho-page-main>div[role="form"]');

    toc.appendTo($('.typecho-page-main'));
    toc.removeClass('hide');

    mainForm.removeClass('col-tb-offset-2');
    mainForm.addClass('col-tb-offset-1');


    $(window).scroll(function() {
        var toc = $('#icarus-config-toc');
        if (!toc.is(':visible'))
            return;
        var currentScroll = $(window).scrollTop() - 100;
        if (currentScroll >= 0) {
            toc.css('top', currentScroll + 'px');
        } else {
            toc.css('top', '0');
        }
    });

    $('#icarus-save-btn').on('click', function () {
        $('.typecho-page-main>div[role="form"]>form button[type="submit"]').click();
    });
});

SCRIPT;
        $script->html($jsCode);

        $this->_form->addItem($container);
        $this->_form->addItem($script);
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
        $key = self::prefixKey($key);
        $value = Icarus_Util::$options->$key;
        $exist = !Icarus_Util::isEmpty($value);
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

    public static function cfgVersionMatch()
    {
        return Icarus_Config::get('config_version') === __ICARUS_VERSION__;
    }
}

class Icarus_Form_Element_Text extends Typecho_Widget_Helper_Form_Element_Text
{
    public function value($value)
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Textarea extends Typecho_Widget_Helper_Form_Element_Textarea
{
    public function value($value)
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Radio extends Typecho_Widget_Helper_Form_Element_Radio
{
    public function value($value)
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Checkbox extends Typecho_Widget_Helper_Form_Element_Checkbox
{
}

class Icarus_Form_VersionField extends Typecho_Widget_Helper_Form_Element_Hidden
{
    public function __construct()
    {
        parent::__construct(Icarus_Config::prefixKey('config_version'), NULL, __ICARUS_VERSION__);
    }

    public function value($value)
    {
        return parent::value(__ICARUS_VERSION__);
    }
}