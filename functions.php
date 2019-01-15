<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeInit($widget)
{
    define('__ICARUS_ROOT__', $widget->getThemeDir());
    require __ICARUS_ROOT__ . 'library/Util.php';
    require __ICARUS_ROOT__ . 'library/Widget.php';
    require __ICARUS_ROOT__ . 'library/Page.php';
    require __ICARUS_ROOT__ . 'library/Assets.php';

    Icarus_Util::init();
    Icarus_Assets::init();
    Icarus_Widget::init($widget);
}

function themeConfig($form)
{
    
}
