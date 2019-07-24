<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module
{
    private static $_moduleList = array(
        'Single', 
        'Navbar', 
        'Profile', 
        'Archive', 
        'Category', 
        'Link', 
        'RecentPost', 
        'Tag', 
        'Toc', 
        'Search', 
        'Comments', 
        'Donate', 
        'Paginator'
    );
    private static $_moduleLoaded = array();

    public static function load($name)
    {
        if (!in_array($name, self::$_moduleList))
            return FALSE;
        if (!in_array($name, self::$_moduleLoaded)) {
            require __ICARUS_ROOT__ . 'library/Module/' . $name . '.php';
            self::$_moduleLoaded[] = $name;
        }
        return TRUE;
    }

    public static function show($name)
    {
        if (!self::load($name))
            return;
        $params = func_get_args();
        array_shift($params);
        call_user_func_array(array('Icarus_Module_' . $name, 'output'), $params);
    }

    public static function enabled($name)
    {
        return Icarus_Config::get(Icarus_Util::parseName($name) . '_enable', FALSE) == TRUE;
    }

    public static function config($form)
    {
        foreach (self::$_moduleList as $moduleName)
        {
            if (self::load($moduleName))
            {
                $moduleClass = 'Icarus_Module_' . $moduleName;
                if (method_exists($moduleClass, 'config'))
                {
                    call_user_func(array($moduleClass, 'config'), $form);
                }
            }
        }
    }
}