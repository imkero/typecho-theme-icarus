<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeInit($widget)
{
    define('__ICARUS_ROOT__', $widget->getThemeDir());
    require __ICARUS_ROOT__ . 'library/Util.php';
    require __ICARUS_ROOT__ . 'library/I18n.php';
    require __ICARUS_ROOT__ . 'library/Widget.php';
    require __ICARUS_ROOT__ . 'library/Page.php';
    require __ICARUS_ROOT__ . 'library/Assets.php';
    require __ICARUS_ROOT__ . 'library/Config.php';

    Icarus_Util::init();
    Icarus_I18n::init();
    Icarus_Assets::init();
    Icarus_Widget::init($widget);
}


function themeConfig($form)
{
    define('__ICARUS_ROOT__', dirname(__FILE__) . '/');
    require __ICARUS_ROOT__ . 'library/Util.php';
    require __ICARUS_ROOT__ . 'library/I18n.php';
    require __ICARUS_ROOT__ . 'library/Widget.php';
    require __ICARUS_ROOT__ . 'library/Config.php';
    require __ICARUS_ROOT__ . 'library/Page.php';

    Icarus_Util::init();
    Icarus_I18n::init();

    Icarus_Widget::load('Navbar');

    $iForm = new Icarus_Config($form);

    $iForm->showTitle(_IcT('setting.general.title'));
    $iForm->makeHtml(sprintf(_IcT('setting.general.desc'), Icarus_Util::$options->theme));

    Icarus_Page::config($form);
    Icarus_Widget_Navbar::config($iForm);
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

function _IcCfg($key, $default = null)
{
    return Icarus_Config::get($key, $default);
}

function _IcCfgExist($key)
{
    return Icarus_Config::has($key);
}