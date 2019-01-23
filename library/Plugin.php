<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin
{
    const ENABLE = '1';
    const DISABLE = '0';

    private static $_pluginList = array(
        'Moment', 
        'Animejs', 
        'Highlight', 
        'BackToTop', 
        'Clipboard', 
        'Gallery',
        'Mathjax',
        'OutdatedBrowser',
        'Progressbar'
    );
    private static $_pluginLoaded = array();

    public static function load($name)
    {
        if (!in_array($name, self::$_pluginList))
            return FALSE;
        if (!in_array($name, self::$_pluginLoaded)) {
            require __ICARUS_ROOT__ . 'library/Plugin/' . $name . '.php';
            self::$_pluginLoaded[] = $name;
        }
        return TRUE;
    }

    public static function header($pluginName)
    {
        if (!self::load($pluginName))
            return;
        
        $pluginClass = 'Icarus_Plugin_' . $pluginName;
        
        $params = func_get_args();
        array_shift($params);
        
        if (method_exists($pluginClass, 'header'))
        {
            call_user_func_array(array($pluginClass, 'header'), $params);
        }
    }

    public static function footer($pluginName)
    {
        if (!self::load($pluginName))
            return;
        
        $pluginClass = 'Icarus_Plugin_' . $pluginName;
        
        $params = func_get_args();
        array_shift($params);
        
        if (method_exists($pluginClass, 'footer'))
        {
            call_user_func_array(array($pluginClass, 'footer'), $params);
        }
    }

    public static function enabled($pluginName)
    {
        return Icarus_Config::get(Icarus_Util::parseName($pluginName) . '_enable', FALSE) == TRUE;
    }

    public static function config($form)
    {
        foreach (self::$_pluginList as $pluginName)
        {
            if (self::load($pluginName))
            {
                $pluginClass = 'Icarus_Plugin_' . $pluginName;
                if (method_exists($pluginClass, 'config'))
                {
                    call_user_func(array($pluginClass, 'config'), $form);
                }
            }
        }
    }

    public static function headerAll()
    {
        foreach (self::$_pluginList as $pluginName)
        {
            if (self::enabled($pluginName))
            {
                self::header($pluginName);
            }
        }
    }

    public static function footerAll()
    {
        foreach (self::$_pluginList as $pluginName)
        {
            if (self::enabled($pluginName))
            {
                self::footer($pluginName);
            }
        }
    }

    public static function basicConfig($form, $pluginName, $defaultEnable)
    {
        $form->packTitle($pluginName);

        $form->makeRadio(
            Icarus_Util::parseName($pluginName) . '_enable', 
            _IcT('setting.plugin_common.enable.title'), 
            NULL,
            array(
                '0' => _IcT('setting.plugin_common.enable.options.0'),
                '1' => _IcT('setting.plugin_common.enable.options.1'),
            ),
            $defaultEnable
        );
    }
}