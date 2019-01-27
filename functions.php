<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__ICARUS_ROOT__', dirname(__FILE__) . '/');

function themeInit($widget)
{
    require __ICARUS_ROOT__ . 'library/Util.php';
    require __ICARUS_ROOT__ . 'library/I18n.php';
    require __ICARUS_ROOT__ . 'library/Module.php';
    require __ICARUS_ROOT__ . 'library/Aside.php';
    require __ICARUS_ROOT__ . 'library/Plugin.php';
    require __ICARUS_ROOT__ . 'library/Page.php';
    require __ICARUS_ROOT__ . 'library/Assets.php';
    require __ICARUS_ROOT__ . 'library/Config.php';
    require __ICARUS_ROOT__ . 'library/Content.php';

    Icarus_Util::init($widget);
    Icarus_I18n::init();
    Icarus_Assets::init();
    Icarus_Aside::init();
}

function themeConfig($form)
{
    require __ICARUS_ROOT__ . 'library/Util.php';
    require __ICARUS_ROOT__ . 'library/I18n.php';
    require __ICARUS_ROOT__ . 'library/Module.php';
    require __ICARUS_ROOT__ . 'library/Aside.php';
    require __ICARUS_ROOT__ . 'library/Plugin.php';
    require __ICARUS_ROOT__ . 'library/Page.php';
    require __ICARUS_ROOT__ . 'library/Assets.php';
    require __ICARUS_ROOT__ . 'library/Config.php';
    require __ICARUS_ROOT__ . 'library/Content.php';

    Icarus_Util::init(NULL);
    Icarus_I18n::init();

    $iForm = new Icarus_Config($form);
    
    Icarus_Config::config($iForm);
    Icarus_Page::config($iForm);
    Icarus_Content::config($iForm);
    Icarus_Aside::config($iForm);
    Icarus_Module::config($iForm);
    Icarus_Plugin::config($iForm);
    Icarus_Assets::config($iForm);

    $iForm->toc();
}

// Icarus Translation 
function _IcT($key)
{
    return Icarus_I18n::get($key);
}

// Icarus Translation + Print
function _IcTp($key)
{
    echo Icarus_I18n::get($key);
}
