<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_Moment
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Moment', Icarus_Plugin::ENABLE);
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'moment.js', '2.22.2', 'moment-with-locales.min.js');
    }
}