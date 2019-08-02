<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__ICARUS_ROOT__', dirname(__FILE__) . '/');
define('__ICARUS_VERSION__', '1.1.4');
define('__ICARUS_CFG_VERSION__', '3');

if (isset($this))
{
    define('__ICARUS_WIDGET_CLASS__', get_class($this));
}

function themeInit($widget)
{
    static $inited = FALSE;
    if (!$inited)
    {
        $inited = TRUE;

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
        Icarus_Page::init();
    }
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
    require __ICARUS_ROOT__ . 'library/Ajax.php';
    require __ICARUS_ROOT__ . 'library/Backup.php';

    Icarus_Util::init(NULL);
    Icarus_I18n::init();

    Icarus_Ajax::handle();

    $iForm = new Icarus_Config($form);
    
    Icarus_Config::config($iForm);
    Icarus_Page::config($iForm);
    Icarus_Content::config($iForm);
    Icarus_Aside::config($iForm);
    Icarus_Assets::config($iForm);
    Icarus_Module::config($iForm);
    Icarus_Plugin::config($iForm);

    $iForm->toc();
}

/**
 * fix duplicated themeFields() calls made by
 * admin/custom-fields.php
 */
function themeFieldsInit()
{
    static $inited = FALSE;
    if (!$inited)
    {
        require __ICARUS_ROOT__ . 'library/Util.php';
        require __ICARUS_ROOT__ . 'library/I18n.php';
        require __ICARUS_ROOT__ . 'library/Content.php';
        
        Icarus_Util::init(NULL);
        Icarus_I18n::init();

        $inited = TRUE;
    }
}

function themeFields($form)
{
    themeFieldsInit();
    Icarus_Content::fieldsConfig($form);
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
