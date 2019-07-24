<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_Highlight
{
    const VERSION = '9.13.1';
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Highlight', Icarus_Plugin::ENABLE);

        $form->packInput('Highlight/theme', 'atom-one-light', 'w-40');
    }

    public static function header()
    {
        Icarus_Assets::cdn('css', 'highlight.js', self::VERSION, 'styles/' . Icarus_Config::get('highlight_theme', 'atom-one-light') . '.min.css');
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'highlight.js', self::VERSION, 'highlight.min.js');
    }
}
