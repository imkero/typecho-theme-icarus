<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_Progressbar
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Progressbar', Icarus_Plugin::ENABLE);
    }

    public static function header()
    {
        Icarus_Assets::printThemeCss('progressbar.css');
        Icarus_Assets::cdn('js', 'pace', '1.0.2', 'pace.min.js');
    }
}
