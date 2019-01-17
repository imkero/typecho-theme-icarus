<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__ICARUS_ROOT__', dirname(__FILE__) . '/');

function themeInit($widget)
{
    require __ICARUS_ROOT__ . 'library/Util.php';
    require __ICARUS_ROOT__ . 'library/I18n.php';
    require __ICARUS_ROOT__ . 'library/Widget.php';
    require __ICARUS_ROOT__ . 'library/Page.php';
    require __ICARUS_ROOT__ . 'library/Assets.php';
    require __ICARUS_ROOT__ . 'library/Config.php';

    Icarus_Util::init($widget);
    Icarus_I18n::init();
    Icarus_Assets::init();
    Icarus_Widget::init();
}


function themeConfig($form)
{
    require __ICARUS_ROOT__ . 'library/Util.php';
    require __ICARUS_ROOT__ . 'library/I18n.php';
    require __ICARUS_ROOT__ . 'library/Widget.php';
    require __ICARUS_ROOT__ . 'library/Page.php';
    require __ICARUS_ROOT__ . 'library/Assets.php';
    require __ICARUS_ROOT__ . 'library/Config.php';

    Icarus_Util::init(null);
    Icarus_I18n::init();

    Icarus_Widget::load('Navbar');
    Icarus_Widget::load('Post');
    Icarus_Widget::load('Search');

    $iForm = new Icarus_Config($form);

    $iForm->showTitle(_IcT('setting.general.title'));
    $iForm->makeHtml(sprintf(_IcT('setting.general.desc'), Icarus_Util::$options->theme));

    Icarus_Page::config($iForm);
    Icarus_Widget_Navbar::config($iForm);
    Icarus_Widget_Post::config($iForm);
    Icarus_Widget_Search::config($iForm);
    Icarus_Assets::config($iForm);
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
