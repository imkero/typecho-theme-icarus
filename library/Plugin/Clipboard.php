<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_Clipboard
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Clipboard', Icarus_Plugin::ENABLE);
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'clipboard.js', '2.0.4', 'clipboard.min.js');
        Icarus_Assets::printThemeJs('clipboard.js', TRUE);
    }
}
